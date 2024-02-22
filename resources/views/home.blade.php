@extends('layout.base')
@section('content')
<div class="container">
    <div class="card p-3 mt-3">
        <form action="{{route('search')}}" method="GET">
            <div class="row">
                <div class="col-sm-3">
                    <?php
                        //$country = App\Models\Country::all();
                        $country = App\Country::where('status','Published')->get();
                    ?>
                    <label for="country">Country</label>
                    <select class="form-select" id="country" name="country">
                        <option value="">Select Country</option>
                        @foreach($country as $countries)
                        <option value="{{$countries->id}}">{{$countries->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <?php
                        $institute = App\Institute::where('status','Published')->get();
                    ?>
                    <label for="institute">Institute</label>
                    <select class="form-select" id="institute" name="institute">
                        <option value="">Select Institute</option>
                        @foreach($institute as $institutes)
                        <option value="{{$institutes->id}}">{{$institutes->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <?php
                        $level = App\Level::where('status','Published')->get();
                    ?>
                    <label for="country">Study Level</label>
                    <select class="form-select" id="level" name="level">
                        <option value="">Select Study Level</option>
                        @foreach($level as $levels)
                        <option value="{{$levels->id}}">{{$levels->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3">
                    <?php
                        $course = App\Course::where('status','Published')->get();
                    ?>
                    <label for="country">Course</label>
                    <select class="form-select" id="course" name="course">
                        <option value="">Select Course</option>
                        @foreach($course as $courses)
                        <option value="{{$courses->id}}">{{$courses->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-2 w-100">Submit</button>
        </form>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        
        $('#country').change(function(){
            let country_id = $('#country').val();
            let institute = $('#institute').val();
            let level = $('#level').val();
            let course = $('#course').val();
            
            if(country_id != null){
                $.ajax({
                    url:'/api/country/'+country_id,
                    type:'GET',
                    dataType:'json',
                    success: function(response){
                        if(response.status == 200){
                            console.log(response);
                            if(institute == ""){
                                institutes(response.institute);
                            }

                            if(level == ""){
                                levels(response.study_level);
                            }
                            
                            if(course == ""){
                                courses(response.course);
                            }
                        }
                    },
                })
            }
        });

        $('#institute').change(function(){
                let institute_id = $('#institute').val();
                let country = $('#country').val();
                let level = $('#level').val();
                let course = $('#course').val();
                console.log(institute_id);
                if(institute_id != null){
                    $.ajax({
                        url:'/api/institute/'+institute_id,
                        type:'GET',
                        dataType:'json',
                        success: function(response){
                            if(response.status == 200){
                                console.log(response);
                                
                                countries(response.country);
                                
                                if(course == ""){
                                    courses(response.course);
                                }

                                if(level == ""){
                                    levels(response.study_level);
                                }
                                
                            }
                        },
                    })
                }
            });

            $('#level').change(function(){
                let level_id = $('#level').val();
                let country = $('#country').val();
                let institute = $('#institute').val();
                let course = $('#course').val();
                if(level_id != null){
                    $.ajax({
                        url:'/api/level/'+level_id,
                        type:'GET',
                        dataType:'json',
                        success: function(response){
                            if(response.status == 200){
                                console.log(response);
                                countries(response.country);
                                if(institute == ""){
                                    institutes(response.institute);
                                }
                                
                                if(course == ""){
                                    courses(response.course);
                                }
                            }
                        },
                    })
                }
            });

            function countries(array){
                let country = $('#country').val();
                if(array.length>1){
                    if(country == ""){
                        $('#country').html('');
                        $('#country').append('<option value="">Select Country</option>');
                        $.each(array,function(key,item){
                            $('#country').append('<option value="'+item.id+'">'+item.name+'</option>')
                        });
                    }
                }else{
                    if(array.length==1){
                        if(country != array[0].id){
                            $('#country').val(array[0].id);
                        }
                    }else{
                        $('#country').html('');
                        $('#country').append('<option value="">Select Country</option>');
                    }
                }   
            }

            function institutes(array){
                $('#institute').html('');
                $('#institute').append('<option value="">Select Institute</option>');
                $.each(array,function(key,item){
                    $('#institute').append('<option value="'+item.id+'">'+item.name+'</option>')
                });
            }

            function levels(array){
                $('#level').html('');
                $('#level').append('<option value="">Select Study Level</option>');
                $.each(array,function(key,item){
                    $('#level').append('<option value="'+item.id+'">'+item.name+'</option>')
                });
            }

            function courses(array){
                var uniqueCourses = new Set();
                $('#course').html('');
                $('#course').append('<option value="">Select Course</option>');
                $.each(array,function(key,item){
                    uniqueCourses.add(item.id);
                });
                uniqueCourses.forEach(function (courseId) {
                    var course = array.find(function (item) {
                        return item.id === courseId;
                    });

                    if (course) {
                        $('#course').append('<option value="' + course.id + '">' + course.name + '</option>');
                    }
                });
            }
        
    })
</script>
@endsection