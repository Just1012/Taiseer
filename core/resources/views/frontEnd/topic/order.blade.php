<div id="order">
    <div class="row">
        <div class="col-lg-12">
            <br>
            <h4><i class="fa-solid fa-cart-plus"></i> {{ __('frontend.orderForm') }}
            </h4>
            <div class="bottom-article">
                {{Form::open(['route'=>['orderSubmit'],'method'=>'POST','class'=>'orderForm','id'=>'orderForm'])}}
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="order_name"
                               class="form-control-label">{!!  __('frontend.name') !!}</label>
                        {!! Form::text('order_name',@Auth::user()->name, array('placeholder' => __('frontend.yourName'),'class' => 'form-control','id'=>'order_name', 'required'=> '')) !!}
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="order_phone"
                               class="form-control-label">{!!  __('frontend.phone') !!}</label>
                        {!! Form::text('order_phone',"", array('placeholder' => __('frontend.phone'),'class' => 'form-control','id'=>'order_phone', 'required'=> '')) !!}
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="order_email"
                               class="form-control-label">{!!  __('frontend.email') !!}</label>
                        {!! Form::email('order_email',@Auth::user()->email, array('placeholder' => __('frontend.yourEmail'),'class' => 'form-control','id'=>'order_email', 'required'=> '')) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::textarea('order_message','', array('placeholder' => __('frontend.notes'),'class' => 'form-control','id'=>'order_message','rows'=>'5')) !!}
                </div>

                @if(config('smartend.nocaptcha_status'))
                    <div class="form-group">
                        {!! NoCaptcha::renderJs(@Helper::currentLanguage()->code) !!}
                        {!! NoCaptcha::display() !!}
                    </div>
                @endif
                <div class="submit-message"></div>
                <div>
                    <input type="hidden" name="topic_id" value="{{$Topic->id}}">
                    <button type="submit" id="orderFormSubmit"
                            class="btn btn-lg btn-theme"><i
                            class="fa-solid fa-paper-plane"></i> {{ __('frontend.sendOrder') }}
                    </button>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
</div>
@push('after-scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#orderForm').submit(function (evt) {
                evt.preventDefault();
                let btn = $('#orderFormSubmit');
                btn.html("<img src=\"{{ asset('assets/dashboard/images/loading.gif') }}\" style=\"height: 20px\"/> {!! __('frontend.sendOrder') !!}");
                btn.prop('disabled', true);
                var formData = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route("orderSubmit") }}",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        let stat = 'alert-danger';
                        if (result.stat === 'success') {
                            stat = 'alert-success';
                            $('#orderForm')[0].reset();
                        }
                        let confirm = '<div class="alert ' + stat + ' alert-dismissible fade show mt-3" role="alert">' + result.msg + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                        $("#orderForm .submit-message").html(confirm);
                        btn.html('<i class="fa-solid fa-paper-plane"></i> {!! __('frontend.sendOrder') !!}');
                        btn.prop('disabled', false);
                    }
                });
                return false;
            });
        });
    </script>
@endpush
