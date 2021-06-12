<x-guest-layout>
    @section('title','Confirm Order Checkout')
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                {{-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> --}}
            </a>
        </x-slot>
        <h3 class="font-extrabold mb-4 text-2xl">Confirmation for Purchase of <br> Order {{$id}}</h3>
        <div class="mb-4 text-gray-600  text-lg">
            Enter The 8 digit security code sent to {{$email}} to confirm your purchase
        </div>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{route('eshop.checkout.confirm_code')}}">
            @csrf
            <div>
                <x-label for="security_code" :value="__('Security Code')" class="text-lg font-bold"/>
                <input type="hidden" name="order" value="{{$id}}">
                <x-input id="security_code" class="block mt-1 w-full"
                                type="text"
                                name="security_code"
                                required  />
            </div>

            <div class="flex justify-center mt-4">
                <x-button>
                    {{ __('Confirm') }}
                </x-button>
            </div>
        </form>
        <p class="mt-5 text-red-500">If your details are incorrect click the button below to discard your purchase and return to checkout page</p>
        <div class="flex justify-center mt-4">
            <x-button>
                <a href="{{route('eshop.checkout')}}">Discard Purchase</a>
            </x-button>
        </div>
    </x-auth-card>
</x-guest-layout>
