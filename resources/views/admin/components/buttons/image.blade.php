<div class="modal-example">
    <button id="ckfinder-modal-{{ $name }}" type="button" class="btn btn-secondary">Ảnh đại diện</button>
    <div id="output-{{ $name }}" class="image-in-content">
        <input type="hidden" class="custom-file-input" id="{{ $name }}" name="{{ $name }}"
               value="{{ isset($src) ? $src : old( $name ) }}">
        @if(!empty($src))
            <img src="{{ asset($src) }}" alt="" style="max-width: 100%">
            <span class="remove-image" id="remove-image-{{ $name }}"><i class="far fa-times-circle"></i></span>
        @endif
    </div>
</div>
<div style="clear: both"></div>
<style>
    .image-in-content{
        position: relative;
    }
    .remove-image{
        position: absolute;
        right: 0;
        top: 0;
        cursor: pointer;
    }
</style>
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

    var removeImage = document.getElementById( 'remove-image-{{ $name }}' );

    removeImage.onclick = function() {
        document.getElementById('{{ $name }}').value = '';
        var imgElement = document.querySelector('#output-{{ $name }} img');
        imgElement.src = '';
        this.remove()
    };
</script>
