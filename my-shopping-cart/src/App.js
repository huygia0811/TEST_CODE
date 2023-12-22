// Trong App.js
import React, { useState, useEffect } from 'react';
import ProductList from './components/ProductList';
import ShoppingCart from './components/ShoppingCart';
import Nike from './assets/nike.png';
import axios from 'axios';

const App = () => {
  const [cartData, setCartData] = useState([]);
  const [cartTotal, setCartTotal] = useState([]);

  const updateCartData = async () => {
    try {
      const response = await axios.get('http://localhost:8000/public/api/view_cart.php');
      const cartItems = response.data.cart_items;
      const cartTotal = response.data.total_price;
      setCartData(cartItems);
      setCartTotal(cartTotal);
    } catch (error) {
      console.error('Error updating cart data:', error);
    }
  };

  useEffect(() => {
    const fetchCartData = async () => {
      try {
        const response = await axios.get('http://localhost:8000/public/api/view_cart.php');
        const cartItems = response.data.cart_items;
        setCartData(cartItems);
      } catch (error) {
        console.error('Error fetching cart data:', error);
      }
    };

    fetchCartData();
  }, []);

  return (
    <div className="flex justify-center items-center h-screen">
      <div className="w-1/2 overflow-y-auto rounded-lg shadow-md mr-5" style={{ width: '360px', height: '600px' }}>
        <div className="p-4 text-[#303841] sticky top-0 z-50 bg-white">
          <img src={Nike} alt="Logo" className="w-12 h-auto inline-block align-middle" />
          <span className="block text-3xl font-bold mt-3">Our Products</span>
        </div>
        {/* Truyền hàm updateCartData xuống ProductList */}
        <ProductList updateCartData={updateCartData} />
      </div>

      <div className="w-1/2 overflow-y-auto rounded-lg shadow-md ml-5" style={{ width: '360px', height: '600px' }}>
        <div className="p-4 text-[#303841] sticky top-0 z-50 bg-white">
            <img src={Nike} alt="Logo" className="w-12 h-auto inline-block align-middle" />

            <div className='flex'>
              <span className="block text-3xl font-bold mt-3">Your Cart</span>
              <span className='ml-14 text-2xl font-bold '>${cartTotal}</span>
            </div>
        </div>
        <ShoppingCart cartData={cartData} updateCartData={updateCartData} />
      </div>
    </div>
  );
};

export default App;
