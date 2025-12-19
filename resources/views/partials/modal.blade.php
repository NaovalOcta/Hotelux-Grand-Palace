<div id="notification-modal" class="fixed inset-0 z-[100] hidden" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm transition-opacity opacity-0" id="modal-backdrop">
    </div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <div id="modal-panel"
                class="relative transform overflow-hidden rounded-2xl bg-gray-800 border border-gray-700 text-left shadow-2xl transition-all opacity-0 scale-95 sm:my-8 sm:w-full sm:max-w-md">

                <div class="px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div id="modal-icon-bg"
                            class="mx-auto flex h-16 w-16 flex-shrink-0 items-center justify-center rounded-full bg-cyan-900/30 sm:mx-0 sm:h-12 sm:w-12">
                            <i id="modal-icon" class="ri-checkbox-circle-line text-3xl text-cyan-400"></i>
                        </div>

                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                            <h3 class="text-xl font-semibold leading-6 text-white tracking-wide" id="modal-title">
                                Booking Confirmed
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-400 leading-relaxed" id="modal-message">
                                    Your reservation has been successfully processed. Check your email for details.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-700/50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-gray-700">
                    <button type="button" id="modal-close-btn"
                        class="inline-flex w-full justify-center rounded-full bg-cyan-500 px-6 py-2 text-sm font-semibold text-gray-900 shadow-sm hover:bg-cyan-400 sm:ml-3 sm:w-auto transition-colors duration-300">
                        Okay, Great!
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
