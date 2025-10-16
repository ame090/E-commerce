<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SellerProductImageController extends Controller
{
    public function destroy(Request $request, Product $product)
    {
        if ($product->seller_id !== auth()->user()->seller->id) {
            abort(403);
        }

        $request->validate([
            'image' => 'required|string',
        ]);

        $images = $product->images ?? [];
        
        // Find and remove the image
        if (($key = array_search($request->image, $images)) !== false) {
            // Delete from storage
            Storage::disk('public')->delete($request->image);
            
            // Remove from array
            unset($images[$key]);
            
            // Re-index array
            $images = array_values($images);
            
            // Update product
            $product->images = $images;
            $product->save();
            
            return back()->with('success', 'Image deleted successfully');
        }

        return back()->with('error', 'Image not found');
    }
}
