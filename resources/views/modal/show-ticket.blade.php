<div x-data="showTicket()" >

    <div id="qrcode"></div>
    <div>
        <h2 class="my-5 text-2xl font-bold text-gray-900" data-uid="{{ $uid }}" id="ticket-uid">
            {{ $uid }}
        </h2>
    </div>

    @script
        
        <script>
            Alpine.data('showTicket', () => ({
                uid: '',
                qr: null,
                init() {
                    console.log('init');
                    this.uid = this.$el.querySelector('#ticket-uid').getAttribute('data-uid');
                    this.qr = new QRCode(this.$el.querySelector('#qrcode'), {
                        text: this.uid,
                        width: 128,
                        height: 128,
                        colorDark: '#000000',
                        colorLight: '#ffffff',
                        correctLevel: QRCode.CorrectLevel.H
                    });
                }
            }));
        </script>
    @endscript
</div>
