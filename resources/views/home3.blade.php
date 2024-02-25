@extends('layout.base')
@section('content')
<div class="container">
    <div class="card p-3 mt-3">
        <form id="search_form" method="GET">
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
                    <label for="level">Study Level</label>
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
                    <label for="course">Course</label>
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
    <div class="row justify-content-center" id="search_data">
    </div>

</div>
@endsection
@section('script')
<script>
    $(document).ready(function(){
        
        $('#country').change(function(){
            let country = $('#country').val();
            let institute = $('#institute').val();
            let level = $('#level').val();
            let course = $('#course').val();
            
            let data = {
                country: country,
                institute:institute,
                level:level,
                course:course
            }
            
            if(country != null){
                $.ajax({
                    url:'/api/all',
                    type:'GET',
                    data:data,
                    dataType:'json',
                    success: function(response){
                        if(response.status == 200){
                            if(institute == ""){
                                institutes(response.institute);
                            }
                            if(institute != ""){
                                institutesValue(response.institute);
                            }

                            if(level == ""){
                                levels(response.study_level);
                            }
                            if(level != ""){
                                levelsValue(response.study_level);
                            }
                            
                            if(course == ""){
                                courses(response.course);
                            }

                            if(course != ""){
                                coursesValue(response.course);
                            }
                        }
                    },
                });
            }
        });

        $('#institute').change(function(){
                let institute = $('#institute').val();
                let country = $('#country').val();
                let level = $('#level').val();
                let course = $('#course').val();

                let data = {
                    institute:institute,
                    level:level,
                    course:course
                }
                console.log(data);
                if(institute != null){
                    $.ajax({
                        url:'/api/all',
                        type:'GET',
                        data:data,
                        dataType:'json',
                        success: function(response){
                            console.log(response);
                            if(response.status == 200){
                                // countries(response.country);
                                
                                if(country == ""){
                                    countriess(response.country);
                                }
                                
                                if(country != ""){
                                    countriesValue(response.country);
                                }

                                if(course == ""){
                                    courses(response.course);
                                }

                                if(course != ""){
                                    coursesValue(response.course);
                                }

                                if(level == ""){
                                    levels(response.study_level);
                                }
                                if(level != ""){
                                    levelsValue(response.study_level);
                                }
                                
                            }
                        },
                    })
                }
            });

            $('#level').change(function(){
                let level = $('#level').val();
                let country = $('#country').val();
                let institute = $('#institute').val();
                let course = $('#course').val();

                let data = {
                    country: country,
                    institute:institute,
                    level:level,
                    course:course
                }

                if(level != null){
                    $.ajax({
                        url:'/api/all',
                        type:'GET',
                        data:data,
                        dataType:'json',
                        success: function(response){
                            console.log(response);
                            if(response.status == 200){
                                if(country == ""){
                                    countriess(response.country);
                                }
                                if(country != ""){
                                    countriesValue(response.country);
                                }

                                if(institute == ""){
                                    institutes(response.institute);
                                }
                                if(institute != ""){
                                    institutesValue(response.institute);
                                }
                                
                                if(course == ""){
                                    courses(response.course);
                                }

                                if(course != ""){
                                    coursesValue(response.course);
                                }
                                
                            }
                        },
                    })
                }
            });

            $('#course').change(function(){
                let level = $('#level').val();
                let country = $('#country').val();
                let institute = $('#institute').val();
                let course = $('#course').val();

                let data = {
                    country: country,
                    institute:institute,
                    level:level,
                    course:course
                }

                if(course != null){
                    $.ajax({
                        url:'/api/all',
                        type:'GET',
                        data:data,
                        dataType:'json',
                        success: function(response){
                            console.log(response);
                            if(response.status == 200){
                                if(country == ""){
                                    countriess(response.country);
                                }
                                if(country != ""){
                                    countriesValue(response.country);
                                }

                                if(institute == ""){
                                    institutes(response.institute);
                                }

                                if(institute != ""){
                                    institutesValue(response.institute);
                                }
                                
                                if(level == ""){
                                    levels(response.study_level);
                                }

                                if(level != ""){
                                    levelsValue(response.study_level);
                                }
                            }
                        },
                    })
                }
            });

            function countriess(array){
                $('#country').html('');
                $('#country').append('<option value="">Select Country</option>');
                if(array.length > 1){
                    $.each(array,function(key,item){
                        $('#country').append('<option value="'+item.countryId+'">'+item.countryName+'</option>');
                    });
                }else{
                    if(array.length == 1){
                        $.each(array,function(key,item){
                            $('#country').append('<option value="'+item.countryId+'">'+item.countryName+'</option>');
                        });
                        $('#country').val(array[0].countryId);
                    }
                    if(array.length == 0){
                        $('#country').html('');
                        $('#country').append('<option value="">Select Country</option>');
                    }
                    
                }
                
            }

            function countriesValue(array){
                if(array.length == 1){
                    $('#country').html('');
                    $('#country').append('<option value="">Select Country</option>');
                    $.each(array,function(key,item){
                        $('#country').append('<option value="'+item.countryId+'">'+item.countryName+'</option>')
                    });
                    $('#country').val(array[0].countryId);
                }
                
            }

            function institutes(array){
                $('#institute').html('');
                $('#institute').append('<option value="">Select Institute</option>');
                if(array.length > 1){
                    $.each(array,function(key,item){
                        $('#institute').append('<option value="'+item.institutesId+'">'+item.institutesName+'</option>')
                    });
                }else{
                    if(array.length == 1){
                        $.each(array,function(key,item){
                            $('#institute').append('<option value="'+item.institutesId+'">'+item.institutesName+'</option>');
                        });
                        $('#institute').val(array[0].institutesId);
                    }

                    if(array.length == 0){
                        $('#institute').html('');
                        $('#institute').append('<option value="">Select Institute</option>');
                    }
                }
            }

            function institutesValue(array){
                if(array.length == 1){
                    $('#institute').html('');
                    $('#institute').append('<option value="">Select Institute</option>');
                    $.each(array,function(key,item){
                        $('#institute').append('<option value="'+item.institutesId+'">'+item.institutesName+'</option>')
                    });
                    $('#institute').val(array[0].institutesId);
                }
                
            }

            function levels(array){
                $('#level').html('');
                $('#level').append('<option value="">Select Study Level</option>');
                if(array.length > 1){
                    $.each(array,function(key,item){
                        $('#level').append('<option value="'+item.levelId+'">'+item.levelName+'</option>')
                    });
                }else{
                    if(array.length == 1){
                        $.each(array,function(key,item){
                            $('#level').append('<option value="'+item.levelId+'">'+item.levelName+'</option>');
                        });
                        $('#level').val(array[0].institutesId);
                    }

                    if(array.length == 0){
                        $('#level').html('');
                        $('#level').append('<option value="">Select Study Level</option>');
                    }
                }
            }

            function levelsValue(array){
                if(array.length == 1){
                    $('#level').html('');
                    $('#level').append('<option value="">Select Study Level</option>');
                    $.each(array,function(key,item){
                        $('#level').append('<option value="'+item.levelId+'">'+item.levelName+'</option>')
                    });
                    $('#level').val(array[0].levelId);
                }
                
            }

            function courses(array){
                var uniqueCourses = new Set();
                $('#course').html('');
                $('#course').append('<option value="">Select Course</option>');
                if(array.length > 1){
                    $.each(array,function(key,item){
                        $('#course').append('<option value="'+item.courseId+'">'+item.courseName+'</option>')
                    });
                }else{
                    if(array.length == 1){
                        $.each(array,function(key,item){
                            $('#course').append('<option value="'+item.courseId+'">'+item.courseName+'</option>');
                        });
                        $('#course').val(array[0].courseId);
                    }

                    if(array.length == 0){
                        $('#course').html('');
                        $('#course').append('<option value="">Select Course</option>');
                    }
                }
            }

            function coursesValue(array){
                if(array.length == 1){
                    $('#course').html('');
                    $('#course').append('<option value="">Select Course</option>');
                    $.each(array,function(key,item){
                        $('#course').append('<option value="'+item.courseId+'">'+item.courseName+'</option>')
                    });
                    $('#course').val(array[0].courseId);
                }
                
            }
        $('#search_form').submit(function(e){
            e.preventDefault();
            let country = $('#country').val();
            let institute = $('#institute').val();
            let level = $('#level').val();
            let course = $('#course').val();
            
            let data = {
                country: country,
                institute: institute,
                level: level,
                course:course
            }

            $.ajax({
                url:'api/main',
                method:'GET',
                data: data,
                success:function(response){
                    if(response.status == 200){
                        //console.log(response.search_result.length);
                        $('#search_data').html('');
                        $.each(response.search_result,function(key,item){
                            $('#search_data').append('<div class="col-sm-3 m-2"><div class="card mt-4" style="width: 18rem;"><div class="card-body"><h5 class="card-title text-center">'+item.courseName+'</h5><p class="card-text text-center">'+item.countryName+'</p><p class="card-text text-center">'+item.instituteName+'</p><p class="card-text text-center">'+item.levelName+'</p><a href="#" class="btn btn-primary w-100">View Details</a></div></div></div>');
                        });
                        
                    }
                    if(response.status == 404){
                        $('#search_data').html('');
                        $('#search_data').append('<h4 class="text-center mt-3">'+response.search_result+'</h4>');
                    }
                }
            });
        });
    })
</script>
@endsection