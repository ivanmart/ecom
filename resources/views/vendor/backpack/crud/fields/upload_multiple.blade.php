<!-- upload multiple input -->
<div @include('crud::inc.field_wrapper_attributes') >
    <label>{!! $field['label'] !!}</label>
    @include('crud::inc.field_translatable_icon')

	{{-- Show the file name and a "Clear" button on EDIT form. --}}
	@if (isset($field['value']) && count($field['value']))
    <div class="well well-sm file-preview-container" id="image-sort">
    	@foreach($field['value'] as $key => $image)<img
            src="/<?=$image->file?>"
            width="110"
            style="display:inline-block; overflow: hidden; height: 110px; padding: 2px; cursor: move"
        >@endforeach
    </div>
    @endif
	{{-- Show the file picker on CREATE form. --}}
	<input name="{{ $field['name'] }}[]" type="hidden" value="">
	<input
        type="file"
        id="{{ $field['name'] }}_file_input"
        name="{{ $field['name'] }}[]"
        value="@if (old($field['name'])) old($field['name']) @elseif (isset($field['default'])) $field['default'] @endif"
        @include('crud::inc.field_attributes')
        multiple
    >

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
</div>

{{-- FIELD EXTRA JS --}}
{{-- push things in the after_scripts section --}}

    @push('crud_fields_scripts')
        <!-- no scripts -->
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.6.1/Sortable.min.js"></script>
        <script>

            Sortable.create(document.getElementById('image-sort'), {
                animation: 150
            });

	        $(".file-clear-button").click(function(e) {
	        	e.preventDefault();
	        	var container = $(this).parent().parent();
	        	var parent = $(this).parent();
	        	// remove the filename and button
	        	parent.remove();
	        	// if the file container is empty, remove it
	        	if ($.trim(container.html())=='') {
	        		container.remove();
	        	}
	        	$("<input type='hidden' name='clear_{{ $field['name'] }}[]' value='"+$(this).data('filename')+"'>").insertAfter("#{{ $field['name'] }}_file_input");
	        });

	        $("#{{ $field['name'] }}_file_input").change(function() {
	        	console.log($(this).val());
	        	// remove the hidden input, so that the setXAttribute method is no longer triggered
	        	$(this).next("input[type=hidden]").remove();
	        });
        </script>
    @endpush
