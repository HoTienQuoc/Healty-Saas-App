@extends('admin.layouts.app')

@section('title')
    Edit product
@endsection

@section('content')
    <div class="row my-5">
        <div class="col-md-3">
            @include('admin.layouts.sidebar')
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-white">
                    <h3 class="mt-2">
                        Edit product
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mx-auto">
                            <form action="{{route('admin.products.update',$product->id)}}" method="post"
                             enctype="multipart/form-data">
                                @csrf
                                @method("PUT")
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name*</label>
                                    <input
                                        type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        name="name"
                                        id="name"
                                        placeholder="Name*"
                                        value="{{old('name',$product->name)}}"
                                    />
                                    @error('name')
                                        <div class="invalid-feedback">
                                            <strong>
                                                {{ $message }}
                                            </strong>
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="image_path" class="form-label">Thumbnail*</label>
                                    <input
                                        type="file"
                                        class="form-control @error('image_path') is-invalid @enderror"
                                        name="image_path"
                                        id="image_path"
                                    />
                                    @error('image_path')
                                        <div class="invalid-feedback">
                                            <strong>
                                                {{ $message }}
                                            </strong>
                                        </div>
                                    @enderror
                                </div>
                                <div class="mt-2">
                                    <img src="#"
                                        id="thumbnail_preview"
                                        class="d-none img-fluid rounded mb-2"
                                        width="100"
                                        height="100"
                                    >
                                </div>
                                <div class="mb-3">
                                    <label for="" class="form-label">Description*</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                        name="description"
                                        id="description" rows="3"
                                        placeholder="Description*"
                                        >{{old('description',$product->description)}}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">
                                            <strong>
                                                {{ $message }}
                                            </strong>
                                        </div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-sm btn-dark">
                                    Submit
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
