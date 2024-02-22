@extends('layout.base')
@section('content')
<div class="container">
    <div class="card p-3 mt-3">
        <form action="" method="GET">
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
            var uniqueCourses = new Set();
            if(country_id != null){
                $.ajax({
                    url:'/api/country/'+country_id,
                    type:'GET',
                    dataType:'json',
                    success: function(response){
                        if(response.status == 200){
                            console.log(response);
                            $('#institute').html('');
                            $('#level').html('');
                            $('#course').html('');
                            $('#institute').append('<option value="">Select Institute</option>');
                            $('#level').append('<option value="">Select Study Level</option>');
                            $('#course').append('<option value="">Select Course</option>');
                            $.each(response.institute,function(key,item){
                                $('#institute').append('<option value="'+item.id+'">'+item.name+'</option>')
                            });
                            $.each(response.study_level,function(key,item){
                                $('#level').append('<option value="'+item.id+'">'+item.name+'</option>')
                            });
                            $.each(response.course,function(key,item){
                                uniqueCourses.add(item.id);
                            });

                            uniqueCourses.forEach(function (courseId) {
                                var course = response.course.find(function (item) {
                                    return item.id === courseId;
                                });

                                if (course) {
                                    $('#course').append('<option value="' + course.id + '">' + course.name + '</option>');
                                }
                            });
                        }
                    },
                })
            }
        });
        
    })
</script>
@endsection