<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Auth;

class CartController extends Controller
{
    public function view()
    {
        $cartItems = CartItem::where('Usu_documento', Auth::user()->Usu_documento)->get();
        $total = $cartItems->sum(function($item) {
            return $item->product->prod_precio * $item->cart_cantidad;
        });
        
        return view('carrito.index', compact('cartItems', 'total'));
    }

    public function add(Request $request, $prod_id)
    {
        $product = Product::findOrFail($prod_id);
        $cantidad = $request->input('cantidad', 1);
        $talla = $request->input('talla');

        if ($product->talla && !$talla) {
            return back()->with('error', 'Debes seleccionar una talla');
        }

        if ($talla && !in_array($talla, ['XS', 'S', 'M', 'L'])) {
            return back()->with('error', 'Talla no válida');
        }

        if ($cantidad <= 0 || $cantidad > $product->prod_cantidad) {
            return back()->with('error', 'Cantidad inválida o no disponible');
        }

        $cartItem = CartItem::where('Usu_documento', Auth::user()->Usu_documento)
                            ->where('prod_id', $prod_id)
                            ->where('talla', $talla)
                            ->first();

        if ($cartItem) {
            $newQty = $cartItem->cart_cantidad + $cantidad;
            if ($newQty <= $product->prod_cantidad) {
                $cartItem->update(['cart_cantidad' => $newQty]);
            } else {
                return back()->with('error', 'No hay suficiente stock');
            }
        } else {
            CartItem::create([
                'Usu_documento' => Auth::user()->Usu_documento,
                'prod_id' => $prod_id,
                'cart_cantidad' => $cantidad,
                'talla' => $talla,
            ]);
        }

        return back()->with('success', 'Producto agregado al carrito');
    }

    public function remove($cart_id)
    {
        $cartItem = CartItem::findOrFail($cart_id);

        if ((string) $cartItem->Usu_documento !== (string) Auth::user()->Usu_documento) {
            abort(403);
        }

        $cartItem->delete();
        
        return back()->with('success', 'Producto removido del carrito');
    }

    public function updateQuantity(Request $request, $cart_id)
    {
        $cartItem = CartItem::findOrFail($cart_id);

        if ((string) $cartItem->Usu_documento !== (string) Auth::user()->Usu_documento) {
            abort(403);
        }
        
        $cantidad = $request->input('cantidad');
        if ($cantidad <= 0 || $cantidad > $cartItem->product->prod_cantidad) {
            return back()->with('error', 'Cantidad inválida');
        }

        $cartItem->update(['cart_cantidad' => $cantidad]);
        return back()->with('success', 'Carrito actualizado');
    }

    public function clear()
    {
        CartItem::where('Usu_documento', Auth::user()->Usu_documento)->delete();
        return back()->with('success', 'Carrito vaciado');
    }
}
