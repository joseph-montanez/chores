@extends('layouts.app')

@section('content')
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">{{ $worker->id ? 'Edit' : 'Add' }} Worker</div>

                    <p class="text-center text-info"><span class="required">*</span> denotes required fields</p>

                    @if (isset($errors) && count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @include('shared.flash')

                    {!! Form::model($worker, ['route' => $worker->id ? ['worker.edit.store', $worker->id] : 'worker.add.store']) !!}

                    <div class="card-body">

                        <div class="form-group"> <!-- Name -->
                            {!! Form::label('name_id', 'Name<span class="required">*</span>', [
                                    'class' => '',
                            ], false) !!}
                            {!! Form::text('name', null, [
                                'id' => 'name_id',
                                'class' => 'form-control',
                                'placeholder' => ''
                            ]) !!}
                        </div>

                        <div class="form-group"> <!-- Email -->
                            {!! Form::label('email_id', 'Email<span class="required">*</span>', [
                                    'class' => '',
                            ], false) !!}
                            {!! Form::email('email', $worker->user->email, [
                                'id' => 'email_id',
                                'class' => 'form-control',
                                'placeholder' => ''
                            ]) !!}
                        </div>

                        <div class="form-group">
                            <label>Enable Notifications</label>
                            <p class="text-muted">How does this worker want to be notified?</p>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="notice_by" id="notice_by_none" value="{{ App\User::NOTICE_BY_NONE }}" {{ old('notice_by', $worker->user->notice_by) == App\User::NOTICE_BY_NONE ? 'checked' : '' }}>
                                <label class="form-check-label" for="notice_by_none">
                                    Do Not Send Notices
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="notice_by" id="notice_by_email" value="{{ App\User::NOTICE_BY_EMAIL}}" {{ old('notice_by', $worker->user->notice_by) == App\User::NOTICE_BY_EMAIL ? 'checked' : '' }}>
                                <label class="form-check-label" for="notice_by_email">
                                    By Email
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="notice_by" id="notice_by_sms" value="{{ App\User::NOTICE_BY_SMS }}" {{ old('notice_by', $worker->user->notice_by) == App\User::NOTICE_BY_SMS ? 'checked' : '' }}>
                                <label class="form-check-label" for="notice_by_sms">
                                    By Text Message
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="notice_by" id="notice_by_push" value="{{ App\User::NOTICE_BY_PUSH }}" {{ old('notice_by', $worker->user->notice_by) == App\User::NOTICE_BY_PUSH ? 'checked' : '' }}>
                                <label class="form-check-label" for="notice_by_push">
                                    By Push Notification (Using Pushover)
                                </label>
                            </div>
                        </div>

                        <div class="form-group sms-options"> <!-- Phone -->
                            {!! Form::label('phone_id', 'Phone (For SMS)', [
                                    'class' => '',
                            ], false) !!}
                            {!! Form::tel('phone', $worker->user->phone, [
                                'id' => 'phone_id',
                                'class' => 'form-control',
                                'placeholder' => ''
                            ]) !!}
                        </div>
                        <div class="form-group sms-options"> <!-- Phone -->
                            <p class="text-muted">How do you want to have the text message send?</p>
                            <div class="">
                                <div class="checkbox">
                                    <label>
                                        <input type="radio" value="{{ App\User::SMS_BY_TEXT }}" name="sms_by"
                                                {{ old('sms_by', $worker->user->sms_by) == App\User::SMS_BY_TEXT ? 'checked' : '' }}>
                                        Send Text Messages via SMS Gateway (Subscription Required)
                                        <p class="text-info">
                                            This will send text messages through a SMS gateway. This is how most text
                                            messages are send and are recieves shortly after the request is sent.
                                        </p>
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="radio" value="{{ App\User::SMS_BY_EMAIL }}" name="sms_by"
                                                {{ old('sms_by', $worker->user->sms_by) == App\User::SMS_BY_EMAIL ? 'checked' : '' }}>
                                        Send Text Messages via Email (Free)
                                        <select name="sms_email">
                                            @foreach (\App\Sms\Numberlist::$providerList as $country_code => $items)
                                            <optgroup label="{{ $country_code }}">
                                                @foreach ($items as $provider => $item):
                                                    <option value="{{ $item }}"
                                                            {{ old('sms_email', $worker->user->sms_email) == $item ? 'selected' : '' }}>
                                                        {{ $provider }} - {{ $item }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                            @endforeach
                                        </select>
                                        <p class="text-info">
                                            This will send text messages through a your telecom's email to SMS gateway.
                                            This is a free feature, but deleiver times will vary and not all providers
                                            suppoer this option. If your provider is not listed then please contact us.
                                            You can also just use the email options and put in your known phone number
                                            email provider in there.
                                        </p>
                                    </label>
                                </div>
                            </div>
                        </div>


                        <div class="form-group push-options"> <!-- Push Notification -->
                            {!! Form::label('pushover_key_id', 'Pushover (For Push Notifications)', [
                                    'class' => '',
                            ], false) !!}
                            {!! Form::text('pushover_key', $worker->user->pushover_key, [
                                'id' => 'pushover_key_id',
                                'class' => 'form-control',
                                'placeholder' => ''
                            ]) !!}
                            <a href="{{ env('PUSHOVER_SUBSCRIPTION_URL') }}" target="_blank">Subscribe for Push Notifications</a>
                            <p class="text-info">
                                Currently {{ config('app.name') }} does not have a dedicated iOS or Android app. If you
                                want notifcations that are faster than SMS and email then push notifications are much
                                faster. However this feature is not free, you need to pay Pushover a one time fee.
                                Download pushover for iOS or Android, and then click the link listed above.
                            </p>
                        </div>

                        @if(!$worker->id)
                        <div class="form-group clearfix"> <!-- Password -->
                            {!! Form::label('password_id', 'Password<span class="required">*</span>', [
                                    'class' => 'control-label col-sm-4',
                            ], false) !!}
                            <div class="col-sm-8">
                                {!! Form::password('password', [
                                    'id' => 'password_id',
                                    'class' => 'form-control',
                                    'placeholder' => ''
                                ]) !!}
                            </div>
                        </div>

                        <div class="form-group clearfix"> <!-- Password Confirmation -->
                            {!! Form::label('password_confirmation_id', 'Password Confirmation<span class="required">*</span>', [
                                    'class' => 'control-label col-sm-4',
                            ], false) !!}
                            <div class="col-sm-8">
                                {!! Form::password('password_confirmation', [
                                    'id' => 'password_confirmation_id',
                                    'class' => 'form-control',
                                    'placeholder' => ''
                                ]) !!}
                            </div>
                        </div>
                        @endif

                    </div>

                    <div class="card-footer text-center"> <!-- Submit Button -->
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        var notice_types = document.querySelectorAll('[name="notice_by"]');
        var smsOptionsElems = document.querySelectorAll('.sms-options');
        var pushOptionsElems = document.querySelectorAll('.push-options');
        notice_types.forEach(function (input, i) {
            input.addEventListener('change', function (evt) {
                pushOptionsElems.forEach(function (elem, n) {
                    elem.style.display = 'none';
                });
                smsOptionsElems.forEach(function (elem, n) {
                    elem.style.display = 'none';
                });
                if (event.target.value === '{{ App\User::NOTICE_BY_SMS }}') {
                    smsOptionsElems.forEach(function (elem, n) {
                        elem.style.display = 'block';
                    });
                } else if (event.target.value === '{{ App\User::NOTICE_BY_PUSH }}') {
                    pushOptionsElems.forEach(function (elem, n) {
                        elem.style.display = 'block';
                    });
                }
            });
        });

        //-- Trigger the change event on the intial checked radio button
        var checked_notice_type = document.querySelector('[name="notice_by"]:checked');
        var event = new CustomEvent('change', {});
        checked_notice_type.dispatchEvent(event);
    </script>
@endsection
