<div 
    x-data="{
        show: false,
        message: '',
        type: 'success',
        init() {
            window.addEventListener('toast-notification', (event) => {
                this.message = event.detail.message;
                this.type = event.detail.type || 'success';
                this.show = true;
                setTimeout(() => { this.show = false; }, 5000);
            });
        }
    }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300 transform"
    x-transition:enter-start="opacity-0 translate-y-[-100%] scale-95"
    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
    x-transition:leave="transition ease-in duration-200 transform"
    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
    x-transition:leave-end="opacity-0 translate-y-[-100%] scale-95"
    class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50 max-w-lg w-full px-4 pointer-events-none"
    style="display: none;"
>
    <div 
        class="pointer-events-auto rounded-2xl shadow-2xl overflow-hidden border-4 animate-pulse-slow"
        :class="{
            'bg-gradient-to-r from-green-50 to-green-100 border-green-500': type === 'success',
            'bg-gradient-to-r from-red-50 to-red-100 border-red-500': type === 'error',
            'bg-gradient-to-r from-blue-50 to-blue-100 border-blue-500': type === 'info'
        }"
    >
        <div class="p-6 flex items-start">
            <!-- Icon -->
            <div class="flex-shrink-0">
                <template x-if="type === 'success'">
                    <div class="bg-green-500 rounded-full p-3 shadow-lg">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </template>
                <template x-if="type === 'error'">
                    <div class="bg-red-500 rounded-full p-3 shadow-lg">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </template>
                <template x-if="type === 'info'">
                    <div class="bg-blue-500 rounded-full p-3 shadow-lg">
                        <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </template>
            </div>
            
            <!-- Message -->
            <div class="ml-4 flex-1">
                <p 
                    class="text-lg font-bold leading-relaxed"
                    :class="{
                        'text-green-800': type === 'success',
                        'text-red-800': type === 'error',
                        'text-blue-800': type === 'info'
                    }"
                    x-text="message"
                ></p>
            </div>
            
            <!-- Close button -->
            <button 
                @click="show = false"
                class="ml-4 inline-flex flex-shrink-0 rounded-full p-2 transition-all duration-200 hover:scale-110"
                :class="{
                    'text-green-600 hover:bg-green-200': type === 'success',
                    'text-red-600 hover:bg-red-200': type === 'error',
                    'text-blue-600 hover:bg-blue-200': type === 'info'
                }"
            >
                <svg class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>
</div>

<style>
    @keyframes pulse-slow {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.95;
        }
    }
    .animate-pulse-slow {
        animation: pulse-slow 1s ease-in-out 2;
    }
</style>
