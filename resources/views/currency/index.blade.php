@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">Currency</div>
                        <div class="col-md-4 text-right "><a href="{{url('currency/create')}}"><i class="fas fa-plus-circle text-success pr-2"></i>New Currency</a></div>
                    </div>
                </div>

                <!-- Tabs -->
                <ul class="nav nav-tabs center" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Actives Currencies</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Inactives Currencies</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="card-body">
                            <table class='table'>
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Abbreviation</th>
                                        <th>Type</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['currencies'] as $currency)
                                    <tr>
                                        <td>{{$currency->name}}</td>
                                        <td>{{$currency->abbreviation}}</td>
                                        <td>{{$currency->type}}</td>
                                        <td>
                                            <form action="{{url('currency', [$currency->id])}}" method="POST">
                                            {{method_field('DELETE')}}
                                            {{ csrf_field() }}
                                            <a class="btn btn-primary" href='{{ url("currency/$currency->id/edit") }}'><i class="fa fa-edit pr-2" aria-hidden='true'></i>Edit</a> 
                                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash pr-2"></i>Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card-body">
                            <table class='table'>
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Abbreviation</th>
                                        <th>Type</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data['currencies_inactives'] as $currency)
                                    <tr>
                                        <td>{{$currency->name}}</td>
                                        <td>{{$currency->abbreviation}}</td>
                                        <td>{{$currency->type}}</td>
                                        <td>
                                            <a class="btn btn-primary" href='{{ url("currency/$currency->id/restore") }}'><i class="fa fa-trash-restore pr-2" aria-hidden='true'></i>Restore</a> 
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
