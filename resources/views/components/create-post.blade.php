<form id="messageForm" action="{{ route('message.store') }}" class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg m-1" method="POST">
    @csrf
    <h2 class="p-6 text-gray-900 dark:text-gray-100 text-xl">
        {{ __('Send Message') }}
    </h2>
    <div>
        <div class="flex flex-col">
            <input type="hidden" name="id" value="{{$id}}" />
            <textarea name="content" rows="4" class="px-3 py-2 border shadow-sm sm:rounded-lg
                bg-white dark:bg-gray-800
                border-gray-900 dark:border-gray-900
                focus:border-red-500 focus:outline-none 
                text-gray-900 dark:text-gray-100 m-3" placeholder=" {{ __('Write message...') }}"></textarea>
        </div>
    </div>
    <div class="pt-3 m-3">
        <button type="submit"
            class="text-gray-900 dark:text-gray-100 shadow-sm sm:rounded-lg w-full bg-gray-100 dark:bg-gray-900 border border-gray-900 px-4 py-2 transition duration-50 focus:outline-none font-semibold hover:bg-red-500 hover:text-white text-xl cursor-pointer ">
            {{__('Send')}}
        </button>
    </div>
</form>
