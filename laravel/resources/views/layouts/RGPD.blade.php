@if(!isset($_COOKIE['rgpd']) || (isset($_COOKIE['rgpd']) && $_COOKIE['rgpd'] != '4bc4528703b62bf381a6fbaec0b802db7ab8edc7'))

    <footer class="fixed-bottom">
        <div class="container" id="RGPDCollapse">

            <div class="d-flex flex-row bd-highlight alert alert-dark" role="alert">
                <div class="p-2 w-100 bd-highlight">
                    @if(session()->has('expert'))
                        For any desire of modification of your personal data, you have a total control of it at this
                        address: <a href="{{ route('account.update', ['id' => session('expert')['id']]) }}"
                                    class="alert-link">edit my personnal data</a>.
                    @endif
                    For any additional requests, please contact an administrator at this address:
                    <a href="mailto:albenoit@gmail.com" class="alert-link">albenoit@gmail.com</a>


                </div>
                <div class="p-2 flex-shrink-1 bd-highlight">
                    <button id="btn-rgpd" class="btn btn-primary">OK</button>
                </div>
            </div>
        </div>


    </footer>
@endif
<script>
    window.addEventListener("DOMContentLoaded", () => {
        if(document.querySelector('footer') != null) {
            let btnRGPD = document.querySelector('#btn-rgpd')

            btnRGPD.addEventListener('click', () => {
                setCookie('rgpd', '4bc4528703b62bf381a6fbaec0b802db7ab8edc7', 30 * 6)
                document.body.removeChild(document.querySelector('footer'))
            })
        }

    })
</script>