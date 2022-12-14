@extends('backend.layouts.app')
@section('css')
<style>
        
</style>
@endsection
@section('content')

    <!--begin::Content-->
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

        <div class="toolbar" id="kt_toolbar">
            <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
                <div class="page-title d-flex align-items-center flex-wrap me-3 mb-5 mb-lg-0">
                    <h1 class="d-flex align-items-center text-dark fw-bolder fs-3 my-1"> {{$product ? translate('Edit Property') : translate('Create Property') }}</h1>
                    <span class="h-20px border-gray-300 border-start mx-4"></span>
                    <ul class="breadcrumb breadcrumb-separatorless fw-bold fs-7 my-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="#" class="text-muted text-hover-primary"> {{translate('Home')}}</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-300 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted"><a href="{{route('products.all')}}" >{{translate('Properties')}} </a> </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="post d-flex flex-column-fluid" id="kt_post">
            <div id="kt_content_container" class="container-xxl">

                @if (count($errors) > 0)
                    <div class = "alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Languages --}}
                  <div class="card card-flush py-4">
                    <ul class="nav nav-tabs nav-fill border-light">
                        @foreach (\App\Models\Language::all() as $key => $language)
                            <li class="nav-item">
                                <a class="nav-link text-reset @if ($language->code == $lang) active @else bg-soft-dark border-light border-left-0 @endif py-3"
                                    href="{{ route('products.admin.edit', ['id' => $product ? $product->id : 0 , 'lang' => $language->code]) }}">
                                    <img src="{{ static_asset('assets/img/flags/' . $language->code . '.png') }}" height="11"
                                        class="mr-1">
                                    <span>{{ $language->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                {{-- Languages --}}
                <br>

                <form class="form d-flex flex-column flex-lg-row gap-7 gap-lg-6"
                    action="{{ route('products.update',$product ? $product->id : 0) }}" method="POST" enctype="multipart/form-data">
                    <input name="_method" type="hidden" value="POST">

                    <input type="hidden" name="id" value="{{ $product ? $product->id : 0 }}">
                    <input type="hidden" name="lang" value="{{ $lang }}">
                    @csrf
                    

                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-6">         
                    <div class="card card-flush py-4">
                        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-bold mb-n2 nav nav-tabs nav-fill border-light">
                            <li class="nav-item">
                                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                    href="#kt_ecommerce_add_product_general"> {{ translate('General') }} </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab"
                                    href="#kt_ecommerce_add_product_advanced">{{ translate('Advanced') }} </a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                  
                    <div class="tab-pane fade show active" id="kt_ecommerce_add_product_general" role="tab-panel">    
                    <div class="d-flex flex-column gap-7 gap-lg-6">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-flush my-2">
                                    <div data-toggle="collapse" href="#collapsegeneral" role="button" aria-expanded="false" aria-controls="collapseExample" class="border-bottom card-header justify-space-between align-items-center">
                                        <div class="card-title" >
                                            <h3>{{ translate('General')}}</h3>
                                        </div>
                                        <i class="fas fa-arrow-down" ></i>
                                    </div>
                                    <div id="collapsegeneral" class="show card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="required form-label">{{ translate('Property Name') }}</label>
                                            <input type="text" class="form-control mb-2" name="name"
                                                placeholder="{{ translate('Property Name') }}"
                                                value="{{$product ? $product->getTranslation('name', $lang) : ''}}" required />
                                        </div>
        
                                        <div class="col-md-6">
                                            <label class="required form-label">{{ translate('Slug') }}</label>
                                            <input type="text" class="form-control mb-2" name="slug"
                                                placeholder="{{ translate('Property Slug') }}" 
                                                value="{{$product ? $product->slug: ''}}" required />
                                                
                                        </div>
        
                                        <div class="col-md-4">
                                            <label class="required form-label">{{ translate('Refrence Code') }}</label>
                                            <input  type="text" class="form-control mb-2" name="ref" placeholder="{{ translate('Refrence Code') }}" value="{{ $product ? $product->ref : ''}}"/>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="required form-label">{{ translate('Price') }}</label>
                                            <input type="number" lang="en" min="0" value="{{ $product ?$product->unit_price : '0' }}"
                                                step="0.01" placeholder="{{ translate('Unit price') }}"
                                                name="unit_price" class="form-control mb-2" >
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">{{ translate('Published') }}</label>
                                            <select required class="form-select mb-2" data-control="select2" data-placeholder="Select an option" name="published" id="published">
                                                  <option @if($product && $product->published == 0) {{'selected'}} @endif  value="0"> {{ translate('No') }}</option>
                                                  <option @if($product && $product->published == 1) {{'selected'}} @endif value="1"> {{ translate('Yes') }}</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">{{ translate('Approved') }}</label>
                                            <select required class="form-select mb-2" data-control="select2" data-placeholder="Select an option" name="approved" id="approved">
                                                  <option @if($product && $product->approved == 0) {{'selected'}} @endif value="0"> {{ translate('No') }}</option>
                                                  <option @if($product && $product->approved == 1) {{'selected'}} @endif value="1"> {{ translate('Yes') }}</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">{{ translate('Featured') }}</label>
                                            <select required class="form-select mb-2" data-control="select2" data-placeholder="Select an option" name="featured" id="featured">
                                                  <option @if($product && $product->featured == 0) {{'selected'}} @endif value="0"> {{ translate('No') }}</option>
                                                  <option @if($product && $product->featured == 1) {{'selected'}} @endif value="1"> {{ translate('Yes') }}</option>
                                            </select>
                                        </div>
                
                                        <div class="col-md-4">
                                            <label class="form-label">{{ translate('Property Tour Type') }}</label>
                                            <select  class="form-select mb-2" data-control="select2" data-placeholder="Select an option" name="tour_type_id" id="tour_type_id">
                                                    @foreach ($tours as $tour)
                                                        <option {{$product && $product->tour_type_id == $tour->id ? 'selected' : ''}} value="{{$tour->id}}"> {{ $tour->getTranslation('name') }}</option>
                                                    @endforeach
                                            </select>
                                        </div>
              
                                        <div class="col-md-4">
                                            <label class="form-label">{{ translate('Property Furnish Type') }}</label>
                                            <select  class="form-select mb-2" data-control="select2" data-placeholder="Select an option" name="furnish_type_id" id="furnish_type_id">
                                                @foreach ($furnish_types as $furnish_type)
                                                    <option @if($product && $product->furnish_type_id == $furnish_type->id) {{'selected'}} @endif value="{{$furnish_type->id}}">{{ $furnish_type->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">

                                {{-- Property Types--}}
                                <div class="card card-flush my-2">
                                    <div data-toggle="collapse" href="#collapsetypes" role="button" aria-expanded="false" aria-controls="collapseExample" class="border-bottom card-header justify-space-between align-items-center">
                                        <div class="card-title" >
                                            <h3>{{ translate('Property Types')}}</h3>
                                        </div>
                                        <i class="fas fa-arrow-down" ></i>
                                    </div>
                                    <div id="collapsetypes" class=" show card-body">
                                        <div class="">
                                            <label class="form-label">{{ translate('type') }}</label>
                                            <select  class="form-select mb-2" data-control="select2" data-placeholder="Select an option"
                                                name="type_id" id="type_id">
                                                @foreach ($types as $type)
                                                    <option disabled value="{{ $type->id }}"> {{ $type->getTranslation('name') }}</option>
                                                    @foreach ($type->children as $child)
                                                    <option value="{{ $child->id }}" @if($product && $product->type_id == $child->id) selected @endif>-- {{ $child->getTranslation('name') }}</option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="">
                                            <label class="form-label">{{ translate('Property Bath') }}</label>
                                            <select class="form-select mb-2" data-control="select2" data-allow-clear="true" data-placeholder="Select an option"  name="bed_id" id="bed_id">
                                                @foreach ($beds as $bed)
                                                    <option @if($product && $product->bed_id == $bed->id)
                                                        {{'selected'}} @endif value="{{$bed->id}}">{{ $bed->getTranslation('name')}}</option>
                                                @endforeach
                                            </select>
                                        </div>
        
                                        <div class="">
                                            <label class="form-label">{{ translate('Property Bed') }}</label>
                                            <select class="form-select mb-2" data-control="select2" data-allow-clear="true" data-placeholder="Select an option" name="bath_id" id="bath_id">
                                                @foreach ($baths as $bath)
                                                <option @if($product && $product->bath_id == $bath->id)
                                                    {{'selected'}} @endif  value="{{$bath->id}}"> {{ $bath->getTranslation('name') }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                </div>
                            {{-- Property Types --}}


                            {{-- Property Locations--}}
                                    <div class="card card-flush my-2">
                                        <div data-toggle="collapse" href="#collapselocations" role="button" aria-expanded="false" aria-controls="collapseExample" class="border-bottom card-header justify-space-between align-items-center">
                                            <div class="card-title" >
                                                <h3>{{ translate('Property Locations')}}</h3>
                                            </div>
                                            <i class="fas fa-arrow-down" ></i>
                                        </div>
                                        <div id="collapselocations" class="show card-body">
                                            <div class="row">

                                                <div class="col-md-6">
                                                    <label class="form-label">{{ translate('Country') }}</label>
                                                    <select  class="country_change form-select mb-2" data-control="select2" data-placeholder="Select an option"  name="country_id" id="country_id">
                                                            @foreach ($countries as $country)
                                                                <option value="{{ $country->id }}" @if ($product && $product->country_id == $country->id) selected @endif>-- {{ $country->name }}</option>
                                                            @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">{{ translate('State') }}</label>
                                                    <select class="state_change form-select mb-2" data-control="select2" data-placeholder="Select an option"  name="state_id" id="state_id">
                                                            @foreach ($states as $state)
                                                                <option value="{{ $state->id }}" @if ($product && $product->state_id == $state->id) selected @endif>-- {{ $state->name }}</option>
                                                            @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">{{ translate('City') }}</label>
                                                    <select class="city_change form-select mb-2" data-control="select2" data-placeholder="Select an option"  name="city_id" id="city_id">
                                                            @foreach ($cities as $city)
                                                                <option value="{{ $city->id }}" @if ($product && $product->city_id == $city->id) selected @endif>-- {{ $city->name }}</option>
                                                            @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">{{ translate('Area') }}</label>
                                                    <select  class="area_change form-select mb-2" data-control="select2" data-placeholder="Select an option"  name="area_id" id="area_id">
                                                            @foreach ($areas as $area)
                                                                <option value="{{ $area->id }}" @if ($product && $product->area_id == $area->id) selected @endif>-- {{ $area->name }}</option>
                                                            @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">{{ translate('Nested Area') }}</label>
                                                    <select  class="nested_area_change form-select mb-2" data-control="select2" data-placeholder="Select an option"  name="nested_area_id" id="nested_area_id">
                                                            @foreach ($nested_areas as $nested_area)
                                                                <option value="{{ $nested_area->id }}" @if ($product && $product->nested_area_id == $nested_area->id) selected @endif>-- {{ $nested_area->name }}</option>
                                                            @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="required form-label">{{ translate('Longitude') }}</label>
                                                    <input  type="text" class="form-control mb-2" name="longitude" value="{{$product ? $product->longitude : '' }}" />
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="required form-label">{{ translate('Latitude') }}</label>
                                                    <input  type="text" class="form-control mb-2" name="latitude"  value="{{$product ? $product->latitude : ''}}" />
                                                </div>

                                            </div> 
                                        </div>
                                    </div>
                              {{-- Product Locations --}}


                               <!--begin::Dimension-->
                               <div class="card card-flush my-2">
                                <div data-toggle="collapse" href="#collapsedimension" role="button" aria-expanded="false" aria-controls="collapseExample" class="border-bottom card-header justify-space-between align-items-center">
                                    <div class="card-title" >
                                        <h3>{{ translate('Property Dimensions')}}</h3>
                                    </div>
                                    <i class="fas fa-arrow-down" ></i>
                                </div>
                                <div id="collapsedimension" class="collapse card-body ">

                                <div class="py-1">
                                    <label class="required form-label">{{ translate('Unit Type') }}</label>
                                    <select  class="form-control" name="unit_id" >
                                        @foreach ($units as $unit)
                                        <option @if($product && $product->unit_id == $unit->id) {{'selected'}} @endif value="{{$unit->id}}">{{$unit->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="py-1">
                                    <label class="form-label">{{ translate('Unit Value')}}</label>
                                    <input  default="0" type="number" lang="en" class="form-control mb-2" name="unit_value" value="{{$product ? $product->unit_value : ''}}" min="0"  />
                                </div>

                                <div class="py-1">
                                    <label class="form-label">{{ translate('Property Sqft')}}</label>
                                    <input  default="0" type="number" lang="en" class="form-control mb-2" name="search_sqft" value="{{$product ? $product->search_sqft : ''}}" min="0"  />
                                </div>

                                </div>
                            </div>
                        {{-- Dimension --}}
                        
                             </div> 
                             

                             <div class="col-md-6">

                                            {{-- Property Pruposes--}}
                                            <div class="card card-flush my-2">
                                                <div data-toggle="collapse" href="#collapsepurposes" role="button" aria-expanded="false" aria-controls="collapseExample" class="border-bottom card-header justify-space-between align-items-center">
                                                    <div class="card-title" >
                                                        <h3>{{ translate('Property Purposes')}}</h3>
                                                    </div>
                                                    <i class="fas fa-arrow-down" ></i>
                                                </div>
                                                <div id="collapsepurposes" class="show card-body">
                                                    <div class="">
                                                        <select  class="form-select mb-2" data-control="select2" data-placeholder="Select an option"  name="purpose_id" id="purpose_id">
                                                            @foreach ($purposes as $purpose)
                                                                <option disabled> {{ $purpose->getTranslation('name') }}</option>
                                                                @foreach ($purpose->children as $child)
                                                                <option value="{{ $child->id }}" @if ($product && $product->purpose_child_id == $child->id) selected @endif>-- {{ $child->getTranslation('name') }}</option>
                                                                @endforeach
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        {{-- Property Purposes --}}

                                        {{-- Property Agent--}}
                                        <div class="card card-flush my-2">
                                            <div data-toggle="collapse" href="#collapseagent" role="button" aria-expanded="false" aria-controls="collapseExample" class="border-bottom card-header justify-space-between align-items-center">
                                                <div class="card-title" >
                                                    <h3>{{ translate('Property Agent')}}</h3>
                                                </div>
                                                <i class="fas fa-arrow-down" ></i>
                                            </div>
                                            <div id="collapseagent" class="show card-body">
                                                <select  class="form-select mb-2" data-control="select2" data-placeholder="Select an option"  name="user_id" id="user_id">
                                                    @foreach ($users as $user)
                                                    <option value="{{ $user->id }}" @if ($product && $product->user_id == $user->id) selected @endif>-- {{ $user->shop->name }}</option>
                                                    @endforeach
                                            </select>
                                            </div>
                                        </div>
                                    {{-- Property Conditions --}}


                                       {{-- Property Conditions--}}
                                         <div class="card card-flush my-2">
                                            <div data-toggle="collapse" href="#collapsecondition" role="button" aria-expanded="false" aria-controls="collapseExample" class="border-bottom card-header justify-space-between align-items-center">
                                                <div class="card-title" >
                                                    <h3>{{ translate('Property Condition')}}</h3>
                                                </div>
                                                <i class="fas fa-arrow-down" ></i>
                                            </div>
                                            <div id="collapsecondition" class="show card-body">
                                                <select  class="form-select mb-2" data-control="select2" data-placeholder="Select an option" name="conditions" id="conditions">
                                                    @foreach ($conditions as $condition)
                                                        <option @if($product && $condition->id == $product->conditions){{'selected'}} @endif value="{{$condition->id}}"> {{ $condition->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    {{-- Property Conditions --}}


                                    
                                    {{-- Property Tags--}}
                                    <div class="card card-flush my-2">
                                        <div data-toggle="collapse" href="#collapsetags" role="button" aria-expanded="false" aria-controls="collapseExample" class="border-bottom card-header justify-space-between align-items-center">
                                            <div class="card-title" >
                                                <h3>{{ translate('Property Tags')}}</h3>
                                            </div>
                                            <i class="fas fa-arrow-down" ></i>
                                        </div>
                                        <div id="collapsetags" class="collapse card-body">
                                                <div class="">
                                                    <input type="text" class="form-control aiz-tag-input" name="tags[]" id="tags" value="{{ $product ? $product->tags : '' }}" placeholder="{{ translate('Type to add a tag') }}" data-role="tagsinput">
                                                    <div class="text-muted fs-7">
                                                        <span class="text-danger"> {{ translate('Type & hit enter add tag') }}.</span> {{ translate('This is used for search. Input those words by which customer can find this product.') }}
                                                    </div>
                                              </div>
                                        </div>
                                    </div>
                                {{-- Property Tags --}}

                                {{-- Property Amenities--}}
                                <div class="card card-flush my-2">
                                    <div data-toggle="collapse" href="#collapseamenities" role="button" aria-expanded="false" aria-controls="collapseExample" class="border-bottom card-header justify-space-between align-items-center">
                                        <div class="card-title" >
                                            <h3>{{ translate('Property Amenities')}}</h3>
                                        </div>
                                        <i class="fas fa-arrow-down" ></i>
                                    </div>
                                    <div id="collapseamenities" class="collapse card-body">
                                            <div class="">
                                                <?php $amenities_idz = $product ? explode(',',$product->amenities) : []; ?>
                                                <select multiple  class="form-select mb-2" data-control="select2" data-placeholder="Select an option" name="amenities[]" id="amenities">
                                                    @foreach ($amenities as $amenity)
                                                        <option @if(in_array($amenity->id,$amenities_idz)){{'selected'}} @endif value="{{$amenity->id}}"> {{ $amenity->name }}</option>
                                                    @endforeach
                                                </select>
                                          </div>
                                        
                                    </div>
                                </div>
                            {{-- Property Amenities --}}


                             </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                {{-- Property Description --}}
                                   <div class="card card-flush my-2">
                                       <div data-toggle="collapse" href="#collapsedescription" role="button" aria-expanded="false" aria-controls="collapseExample" class="border-bottom card-header justify-space-between align-items-center">
                                           <div class="card-title" >
                                               <h3>{{ translate('Property Description')}}</h3>
                                           </div>
                                           <i class="fas fa-arrow-down" ></i>
                                       </div>
                                       <div id="collapsedescription" class="collapse card-body">
                                           <textarea class="aiz-text-editor" name="description">{{ $product ? $product->getTranslation('description', $lang) : '' }}</textarea>   
                                       </div>
                                   </div>
                                   {{-- Property Description --}}
                           </div>

                         </div>
                    
                       </div>
                   </div>


                   <!--begin::Tab pane-->
                   <div class="tab-pane fade" id="kt_ecommerce_add_product_advanced" role="tab-panel">
                    <div class="d-flex flex-column gap-7 gap-lg-6">
                        <div class="row">


                            <div class="col-md-6">
                                {{-- Property Thumbnail--}}
                                <div class="card card-flush my-2">
                                    <div data-toggle="collapse" href="#collapsethumbnail" role="button" aria-expanded="false" aria-controls="collapseExample" class="border-bottom card-header d-flex justify-content-between align-items-center  "> 
                                        <div class="card-title">
                                            <h3>{{ translate('Property Thumbnail') }}</h3>
                                        </div>
                                        <i class="fas fa-arrow-down" ></i>
                                    </div>
                                    <div id="collapsethumbnail" class="collapse card-body ">
                                            <label class="form-label">{{ translate('Thumbnail Image') }} <b>({{env('THUMBNAIL_IMAGE_WIDTH')}} x {{env('THUMBNAIL_IMAGE_HEIGHT')}})</b></label>
                                            <div class="dropzone" id="kt_ecommerce_add_product_mediaa"
                                                data-toggle="aizuploader" data-type="image">
                                                <div class="dz-message needsclick">
                                                    <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                    <input type="hidden" name="thumbnail_img" class="selected-files"
                                                        value="{{ $product ? $product->thumbnail_img : '' }}">
                                                    <div class="ms-4">
                                                        <h3 class="fs-5 fw-bolder text-gray-900 mb-1"> {{ translate('Click To Upload') }} </h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="file-preview box sm">
                                            </div>
                                    </div>
                                </div>
                                {{-- Property Thumbnail --}}
                            
                                {{-- Property Gallery--}}
                                <div class="card card-flush my-2">
                                    <div data-toggle="collapse" href="#collapsegallery" role="button" aria-expanded="false" aria-controls="collapseExample" class="border-bottom card-header d-flex justify-content-between align-items-center  "> 
                                        <div class="card-title">
                                            <h3>{{ translate('Property Gallery') }}</h3>
                                        </div>
                                        <i class="fas fa-arrow-down" ></i>
                                    </div>
                                    <div id="collapsegallery" class="collapse card-body">
                                        
                                            <label class="form-label">{{ translate('Gallery Images') }} <b>({{env('GRALLERY_IMAGE_WIDTH')}} x {{env('GRALLERY_IMAGE_HEIGHT')}})</b></label>
                                            <div class="dropzone" id="kt_ecommerce_add_product_mediaa"
                                                data-toggle="aizuploader" data-type="image" data-multiple="true">
                                                <div class="dz-message needsclick">
                                                    <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                    <input type="hidden" name="photos" class="selected-files"
                                                        value="{{ $product ? $product->photos : '' }}">
                                                    <div class="ms-4">
                                                        <h3 class="fs-5 fw-bolder text-gray-900 mb-1">{{ translate('Click to upload.')}}</h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="file-preview box sm">
                                            </div>
                                    </div>
                                </div>
                                {{-- Property Gallery --}}
                    

                        
                                <!--Property Video-->
                                <div class="mt-2 card card-flush my-2">
                                        <div data-toggle="collapse" href="#collapsevideo" role="button" aria-expanded="false" aria-controls="collapseExample" class="border-bottom card-header d-flex justify-content-between align-items-center  "> 
                                            <div class="card-title">
                                                <h3>{{ translate('Property Videos') }}</h3>
                                            </div>
                                            <i class="fas fa-arrow-down" ></i>
                                        </div>
                                        <div id="collapsevideo" class="collapse card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="kt_ecommerce_add_product_store_template"
                                                    class="form-label">{{ translate('Property Video ') }}</label>
                                                    <select class="form-select mb-2" data-control="select2"
                                                        data-hide-search="true" data-placeholder="Select an option"
                                                        id="video_provider" name="video_provider">
                                                        <option value="youtube" <?php if ($product && $product->video_provider == 'youtube') {
                                                                echo 'selected';
                                                            } ?>>{{ translate('Youtube') }}
                                                        </option>
                                                        <option value="dailymotion" <?php if ($product &&  $product->video_provider == 'dailymotion') {
                                                                echo 'selected';
                                                            } ?>>
                                                            {{ translate('Dailymotion') }}</option>
                                                        <option value="vimeo" <?php if ($product && $product->video_provider == 'vimeo') {
                                                                echo 'selected';
                                                            } ?>>{{ translate('Vimeo') }}
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="form-label">{{ translate('Video Link') }}</label>
                                                    <input type="text" class="form-control mb-2" name="video_link"
                                                    placeholder="{{ translate('Video Link') }}"
                                                    value="{{$product ? $product->video_link : '' }}">
                                                    <div class="text-muted fs-7">
                                                        {{ translate("Use proper link without extra parameter. Don't use short share link/embeded iframe code.") }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Property Video-->


                                    <div class="card card-flush my-2">
                                        <div data-toggle="collapse" href="#collapseseo" role="button" aria-expanded="false" aria-controls="collapseExample" class="border-bottom card-header justify-space-between align-items-center">
                                                <div class="card-title" >
                                                    <h3>{{ translate('Property Seo Configuration')}}</h3>
                                                </div>
                                                <i class="fas fa-arrow-down" ></i>
                                        </div>
                                        <div id="collapseseo" class="collapse card-body ">
                                            <div class="mb-10">
                                                <label class="form-label">{{ translate('Meta Title') }}</label>
                                                <input type="text" class="form-control mb-2" name="meta_title"
                                                    value="{{ $product ? $product->meta_title : '' }}" placeholder="Meta tag name" />
                                            </div>
                                            <div class="mb-10">
                                                <label class="form-label">{{ translate('Description') }}</label>
                                                <textarea class="form-control"
                                                    name="meta_description">{{ $product ? $product->meta_description : ''}}</textarea>
                                                <div class="text-muted fs-7">{{ translate('Set a meta tag description to the product for increased SEO ranking') }}.
                                                </div>
                                            </div>
                                            <div class="fv-row mb-2">
                                                <label class="form-label">{{ translate('Meta Images') }}</label>
                                                <div class="dropzone" id="kt_ecommerce_add_product_mediaa"
                                                    data-toggle="aizuploader" data-type="image">
                                                    <div class="dz-message needsclick">
                                                        <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                        <input type="hidden" name="meta_img" class="selected-files"
                                                            value="{{ $product ? $product->meta_img : '' }}">
                                                        <div class="ms-4">
                                                            <h3 class="fs-5 fw-bolder text-gray-900 mb-1">Click to upload</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="file-preview box sm"></div>
                                            </div>
                                        </div>
                                    </div>
                                {{-- Seo Meta Tags --}}
                           
                            </div>


                            <div class="col-md-6">

                                   <!--begin::PDF-->
                                    <div class="card card-flush my-2">
                                        <div data-toggle="collapse" href="#collapsepdf" role="button" aria-expanded="false" aria-controls="collapseExample" class="border-bottom card-header justify-space-between align-items-center">
                                            <div class="card-title" >
                                                <h3>{{ translate('Property PDF Specification')}}</h3>
                                            </div>
                                            <i class="fas fa-arrow-down" ></i>
                                        </div>
                                        <div id="collapsepdf" class="collapse card-body ">
                                            
                                                <div class="dropzone" id="kt_ecommerce_add_product_mediaa"
                                                    data-toggle="aizuploader" data-multiple="true" data-type="document">
                                                    <div class="dz-message needsclick">
                                                        <i class="bi bi-file-earmark-arrow-up text-primary fs-3x"></i>
                                                        <input type="hidden" name="pdf" class="selected-files"
                                                            value="{{ $product ? $product->pdf : '' }}">
                                                        <div class="ms-4">
                                                            <h3 class="fs-5 fw-bolder text-gray-900 mb-1">{{ translate('Click to upload.')}}</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="file-preview box sm"></div>
                                        
                                            <div class="text-muted fs-7">
                                                {{ translate('These images are visible in product details page gallery. Use 600x600 sizes images.') }}
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::PDF-->


                                    <!--begin:: External Link -->
                                    <div class="card card-flush my-2">
                                        <div data-toggle="collapse" href="#collapseexternal" role="button" aria-expanded="false" aria-controls="collapseExample" class="border-bottom card-header justify-space-between align-items-center">
                                            <div class="card-title" >
                                                <h3>{{ translate('Property External Links')}}</h3>
                                            </div>
                                            <i class="fas fa-arrow-down" ></i>
                                        </div>
                                        <div id="collapseexternal" class="collapse card-body ">

                                            <div class="">
                                                <label class="required form-label">{{ translate('External link') }}</label>
                                                <input type="text" class="form-control mb-2" name="external_link"
                                                    placeholder="{{ translate('Leave it blank if you do not use external site link') }}"
                                                    value="{{ $product ? $product->external_link : '' }}" />
                                                <div class="text-muted fs-7">
                                                    {{ translate('Leave it blank if you do not use external site link') }}
                                                </div>
                                            </div>
            
                                            <div class="">
                                                <label class="required form-label">{{ translate('External link button text') }}</label>
                                                <input type="text"
                                                    placeholder="{{ translate('External link button text') }}"
                                                    name="external_link_btn" class="form-control mb-2"
                                                    value="{{$product ? $product->external_link_btn : '' }}">
                                                <div class="text-muted fs-7">
                                                    {{ translate('Leave it blank if you do not use external site link') }}
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                {{-- Dimension --}}  
                            </div>
                        </div>
                     </div>
                  </div>
                </div>

                <div class="text-center ">
                    <button type="submit" class=" btn btn-info" >Submit</button>
                </div>

              </div>
           </form>
        </div>
      </div>
    </div>
@endsection
@section('script')

    <script src="{{ static_asset('assets/backend/plugins/custom/formrepeater/formrepeater.bundle.js') }}"></script>
    <script type="text/javascript">

    $(document).ready(function() {


        $(".country_change").change(function(){

            let id = $(this).val();
            $.ajax({
                method: "POST",
                url: "response.php",
                data: {
                    id: countryid
                },
                datatype: "html",
                success: function(data) {
               
                    // $("#state").html(data);
                    // $("#city").html('<option value="">Select city</option');

                }
            });

            // alert(id);
        
          
        });

        $("#state").change(function(){
            
            console.log('state');
          
        });

        $("#city").change(function(){
            
            console.log('country');
          
        });

        $("#area").change(function(){
            
            console.log('country');
          
        });

        $("#nestedarea").change(function(){
            
            console.log('country');
          
        });











                $(".title").keyup(function(){
                    var Text = $(this).val();
                    Text = Text.toLowerCase();
                    Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
                    $(".slug").val(Text);        
                });

                $(window).keydown(function(event){
                    if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                    }
                });
        });

        AIZ.plugins.tagify();
    </script>

@endsection