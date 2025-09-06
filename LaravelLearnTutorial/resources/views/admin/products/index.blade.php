@extends('admin.layouts.app')

@section('title')
    Products
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
                        Products ({{ $products->count() }})
                    </h3>
                    <a href="{{route('admin.products.create')}}" class="btn btn-sm btn-primary">
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
                                    <th>Image</th>
                                    <th>Positives</th>
                                    <th>Negatives</th>
                                    <th>Qr Code</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $key => $product)
                                    <tr>
                                        <td>{{ $key += 1 }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ Str::limit($product->description, 100) }}</td>
                                        <td>
                                            <img src="{{asset($product->image_path)}}"
                                                alt="{{ $product->name }}"
                                                class="img-fluid rounded mb-1"
                                                width="60"
                                                height="60"
                                            >
                                        </td>
                                        <td>
                                            @if ($product->positives->count())
                                                <ul>
                                                    @foreach ($product->positives as $positive)
                                                        <li class="d-flex flex-column">
                                                            <strong> {{ $positive->name }}</strong>
                                                            <p>
                                                                {{ $positive->description }}
                                                            </p>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <span class="badge bg-danger">
                                                    N/A
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($product->negatives->count())
                                                <ul>
                                                    @foreach ($product->negatives as $negative)
                                                        <li class="d-flex flex-column">
                                                            <strong> {{ $negative->name }}</strong>
                                                            <p>
                                                                {{ $negative->description }}
                                                            </p>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <span class="badge bg-success">
                                                    N/A
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <img src="{{asset($product->qr_code_path)}}"
                                                alt="{{ $product->name }}"
                                                class="img-fluid rounded mb-1"
                                                width="60"
                                                height="60"
                                            >
                                        </td>
                                        <td>
                                            <a href="{{route('admin.products.edit',$product->id)}}" class="btn btn-sm btn-warning mb-1">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="#"
                                                onclick="deleteItem({{$product->id}})"
                                                class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            <form id="{{$product->id}}" action="{{route('admin.products.destroy',$product->id)}}" method="post">
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
