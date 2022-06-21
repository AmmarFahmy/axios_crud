<div class="{{ $col_size }} {{ $name }} {{ $class }} d-flex flex-column ">
    <div class="form-group row">
        <label for="{{ $name }}" class="small col-sm-12 col-form-label">
            @if ($required_icon)
                <i class="fas fa-layer-group text-danger"></i>
            @endif
            <span class="small">{{ $text }}</span>
        </label>
        @if ($verticle)
            <div class="col-sm-8 ">
        @endif
        <input type="text" id="{{ $name }}" name="{{ $name }}"
            class="form-control form-control-sm rounded-0 input_textbox" value="{{ $value }}"
            onkeyup="{{ $onkeyup }}" placeholder="{{ $placeholder }}">
        @if ($verticle)
    </div>
    @endif
</div>
</div>
