@extends('admin.admin_layout')

@section('admin_panel')


 <div class="sl-mainpanel">
     

      <div class="sl-pagebody">
        <div class="sl-page-title">
          <h5>Category Table</h5>
         
        </div><!-- sl-page-title -->

        <div class="card pd-20 pd-sm-40">
          <h6 class="card-body-title" style="text-align: center;color: black;">Category Update</h6>


          <div class="table-wrapper">
                
      @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
       <form method="post" action="{{ url('update/category/'.$category->id) }}">
        @csrf
         <div class="modal-body pd-20"> 
        <div class="form-group">
          <label for="exampleInputEmail1">Category Name</label>
          <input type="text" class="form-control" value="{{$category->category_name}}" id="exampleInputEmail1" aria-describedby="emailHelp"  name="category_name">
          
        </div>


              <div class="form-group">
                <label for="exampleInputEmail1">Status</label>
                 <select class="form-control select2" data-placeholder="Choose status" name="status">
                    <option value="{{$category->status}}">No change</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>                   
                  </select>
                </div>


          
              </div><!-- modal-body -->
              <div class="modal-footer">
                <button type="submit" class="btn btn-info pd-x-20" >Update</button>
                <a href="{{route('category')}}" class="btn btn-info pd-x-20">Cancle</a>
              </div>
                </form>
          </div><!-- table-wrapper -->
        </div><!-- card -->

        

 
    </div><!-- sl-mainpanel -->





@endsection