<footer class="bg-black p-5">
    <div class="container mx-auto text-grey-light font-main">
        <div class="my-5">
            <newsletter-form></newsletter-form>
        </div>
        <div class="text-center text-grey-light">
            <ul class="list-reset mb-5">
                <li class="inline-block w-10">
                    <a href="https://www.facebook.com/kazcreole/" target="_blank"><img src="{{ asset('/images/facebook.png') }}"></a>
                </li>
                <li class="inline-block w-10">
                    <a href="https://www.instagram.com/lakazcreole/" target="_blank"><img src="{{ asset('/images/instagram.png') }}"></a>
                </li>
            </ul>
            <p class="mb-5">
                <a href="#" @click.prevent="showContactModal = true" class="text-grey-light">Signaler un bug</a>
            </p>
            <p class="mb-5">
                Made with <span class="text-orange">&hearts;</span> by <a href="http://laurentcazanove.com" target="_blank" class="text-grey-light">Laurent Cazanove</a>.
            </p>
        </div>
    </div>
</footer>
