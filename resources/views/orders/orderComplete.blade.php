
<x-guest-layout>
    @section('title','Confirm Order Checkout')
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                {{-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> --}}
            </a>
        </x-slot>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <p class="text-green-600 text-lg">Congratulations, You have successfully purchased the items</p>
                <p class="text-gray-700">You will soon be contacted by the owner and your order will be delivered as soon as possible</p>
                <p class="text-blue-400">Click the button below to return back to home and continue shopping</p>
            </div>
            <div class="flex justify-end mt-4">
                <x-button>
                    <a href="{{route('eshop.home')}}">Return Home</a>
                </x-button>
            </div>

        </div>
    </x-auth-card>
</x-guest-layout>
