@extends('admin.layouts.app')

@section('title')
    Positives
@endsection

@section('content')
    <div class="row my-5">
        <div class="col-md-3">
            @include('admin.layouts.sidebar')
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h3 class="mt-2">
                        Positives ({{ $positives->count() }})
                    </h3>
                    <a href="{{route('admin.positives.create')}}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
                <div class="card-body">
                    <div
                        class="table-responsive"
                    >
                        <table
                            class="table"
                        >
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Product</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($positives as $key => $positive)
                                    <tr>
                                        <td>{{ $key += 1 }}</td>
                                        <td>{{ $positive->name }}</td>
                                        <td>{{ Str::limit($positive->description, 100) }}</td>
                                        <td>
                                            {{ $positive->product->name }}
                                        </td>
                                        <td>
                                            <a href="{{route('admin.positives.edit',$positive->id)}}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#"
                                                onclick="deleteItem({{$positive->id}})"
                                                class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            <form id="{{$positive->id}}" action="{{route('admin.positives.destroy',$positive->id)}}" method="post">
                                                @csrf
                                                @method("DELETE")
                                            </form>
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
@endsection
