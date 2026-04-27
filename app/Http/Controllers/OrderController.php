<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $cartItems = CartItem::where('Usu_documento', Auth::user()->Usu_documento)->get();
        
        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Tu carrito está vacío');
        }

        $order = Order::create([
            'Usu_documento' => Auth::user()->Usu_documento,
            'ord_estado' => 'pendiente',
            'ord_fechaCreacion' => now(),
            'ord_fechaExpiracion' => now()->addDays(3), // 3 días para recoger
            'ord_total' => 0,
        ]);

        $total = 0;

        foreach ($cartItems as $cartItem) {
            $product = $cartItem->product;
            
            // Deducir del stock
            $product->update(['prod_cantidad' => $product->prod_cantidad - $cartItem->cart_cantidad]);

            OrderItem::create([
                'ord_id' => $order->ord_id,
                'prod_id' => $product->prod_id,
                'oit_cantidad' => $cartItem->cart_cantidad,
                'oit_precio_unitario' => $product->prod_precio,
                'oit_subtotal' => $product->prod_precio * $cartItem->cart_cantidad,
            ]);

            $total += $product->prod_precio * $cartItem->cart_cantidad;
        }

        $order->update(['ord_total' => $total]);

        // Vaciar carrito
        CartItem::where('Usu_documento', Auth::user()->Usu_documento)->delete();

        Notification::create([
            'Usu_documento' => Auth::user()->Usu_documento,
            'Noti_mensaje' => "Pedido #{$order->ord_id} creado. Puedes revisar tu historial de pedidos.",
            'Noti_fecha' => now(),
            'Noti_link' => route('orders.history'),
        ]);

        return redirect()->route('orders.show', $order->ord_id)->with('success', 'Pedido creado exitosamente. Tienes 3 días para recogerlo.');
    }

    public function show($ord_id)
    {
        $order = Order::where('ord_id', $ord_id)
                     ->where('Usu_documento', Auth::user()->Usu_documento)
                     ->firstOrFail();
        
        return view('orders.show', compact('order'));
    }

    public function history()
    {
        $orders = Order::where('Usu_documento', Auth::user()->Usu_documento)
                      ->orderBy('ord_fechaCreacion', 'desc')
                      ->get();
        
        return view('orders.history', compact('orders'));
    }

    // ADMIN: Marcar como pagado/recogido
    public function markAsPickedUp($ord_id)
    {
        $order = Order::findOrFail($ord_id);
        
        $order->update([
            'ord_estado' => 'recogido',
            'ord_fechaRecogida' => now(),
        ]);

        return back()->with('success', 'Pedido marcado como recogido y finalizado.');
    }

    // ADMIN: Cancelar pedido (devolver stock)
    public function cancelOrder($ord_id)
    {
        $order = Order::findOrFail($ord_id);
        
        if ($order->ord_estado === 'recogido') {
            return back()->with('error', 'No se puede cancelar un pedido ya recogido');
        }

        // Devolver stock
        foreach ($order->items as $item) {
            $product = $item->product;
            $product->update(['prod_cantidad' => $product->prod_cantidad + $item->oit_cantidad]);
        }

        $order->update(['ord_estado' => 'cancelado']);

        return back()->with('success', 'Pedido cancelado y stock restaurado.');
    }

    // Cancelar automáticamente pedidos expirados (ejecutar con cron)
    public static function expireOldOrders()
    {
        $expiredOrders = Order::where('ord_estado', 'pendiente')
                             ->where('ord_fechaExpiracion', '<', now())
                             ->get();

        foreach ($expiredOrders as $order) {
            // Devolver stock
            foreach ($order->items as $item) {
                $product = $item->product;
                $product->update(['prod_cantidad' => $product->prod_cantidad + $item->oit_cantidad]);
            }
            $order->update(['ord_estado' => 'cancelado']);
        }
    }
}
