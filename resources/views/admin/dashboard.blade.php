<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-900 text-xl font-bold">Total Orders</div>
                    <div class="text-3xl text-blue-600 font-bold mt-2">{{ $totalOrders }}</div>
                    <a href="{{ route('admin.orders.index') }}" class="text-sm text-blue-500 hover:text-blue-700 mt-2 inline-block">View All</a>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-900 text-xl font-bold">Total Products</div>
                    <div class="text-3xl text-green-600 font-bold mt-2">{{ $totalProducts }}</div>
                    <a href="{{ route('admin.products.index') }}" class="text-sm text-green-500 hover:text-green-700 mt-2 inline-block">Manage Products</a>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-900 text-xl font-bold">Total Customers</div>
                    <div class="text-3xl text-purple-600 font-bold mt-2">{{ $totalUsers }}</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Recent Orders</h3>
                     <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Order ID</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                         <tbody>
                            @foreach($recentOrders as $order)
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">#{{ $order->id }}</td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $order->user->name }}</td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">${{ number_format($order->total_price, 2) }}</td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ ucfirst($order->status) }}</td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <a href="#" class="text-blue-600 hover:text-blue-900">Details</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
