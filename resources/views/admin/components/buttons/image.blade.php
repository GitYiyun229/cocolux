<div class="modal-example">
    <button id="ckfinder-modal-{{ $name }}" type="button" class="btn btn-secondary">Ảnh đại diện</button>
    <div id="output-{{ $name }}">
        <input type="hidden" class="custom-file-input" id="{{ $name }}" name="{{ $name }}"
               value="{{ isset($src) ? $src : old( $name ) }}">
        @if(!empty($src))
            <img src="{{ asset($src) }}" alt="" style="max-width: 100%">
        @endif
    </div>
</div>
<div style="clear: both"></div>
<script>
    function escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    var button = document.getElementById( 'ckfinder-modal-{{ $name }}' );

    button.onclick = function() {
        CKFinder.modal( {
            chooseFiles: true,
            width: 800,
            height: 600,
            onInit: function( finder ) {
                finder.on( 'files:choose', function( evt ) {
                    const file = evt.data.files.first();
                    const output = document.getElementById( 'output-{{ $name }}' );
                    output.innerHTML = '<input type="hidden" class="custom-file-input" id="{{ $name }}" name="{{ $name }}"\n' +
                        '               value="'+escapeHtml( file.getUrl() )+'"><img src="'+escapeHtml( file.getUrl() )+'" alt="" style="max-width: 100%">';
                } );

                finder.on( 'file:choose:resizedImage', function( evt ) {
                    const output = document.getElementById( 'output-{{ $name }}' );
                    output.innerHTML = '<input type="hidden" class="custom-file-input" id="{{ $name }}" name="{{ $name }}"\n' +
                        '               value="'+escapeHtml( evt.data.resizedUrl )+'"><img src="'+escapeHtml( evt.data.resizedUrl )+'" alt="" style="max-width: 100%">';
                } );
            }
        } );
    };
</script>
