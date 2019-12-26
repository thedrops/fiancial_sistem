@extends('layouts.app')
@section('style-import')
<link href="{{ asset('css/custom.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="row">{{$data['title']}}</div>
                </div>

                <form action="{{$data['url']}}" method="POST">
                    {{ csrf_field() }}
                    @if($data['model'])
                        @method('PUT')
                    @endif                    
                    <div class="card-body">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="md-form">
                                    <label for="name">Name</label>
                                    <input type="text" name="bank[name]" id="name" value="{{ $data['model'] ? $data['model']->name : old('name', '') }}" class='form-control'>
                                </div>
                            </div>

                            <div class="col-sm-6 mb-2">
                                <label for="currency">Currency</label>
                                <select id='currency' name='bank[currency_id]' class="browser-default custom-select ">
                                    <option value="" disabled selected>Choose your option</option>
                                    @foreach($data['currencies'] as $currency)
                                        <option {{ $data['model'] && $data['model']->currency->id == $currency->id ? 'selected' : '' }} value="{{$currency->id}}">{{$currency->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-sm-2">
                                <a href="{{url('bank')}}" class="btn btn-light left"><i class="fas fa-undo pr-2" aria-hidden="true"></i>Back</a>
                            </div>

                            <div class="col-sm-2 offset-sm-8">
                                <button type="submit" class="btn btn-success right width-100"><i class="fas fa-save pr-2" aria-hidden="true"></i>{{$data['button']}}</button>
                            </div>

                        </div>

                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>
@endsection