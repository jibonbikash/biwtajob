<?php
/**
 * Created by  jibon Bikash Roy.
 * User: jibon
 * Date: ২১/১/২৩
 * Time: ৮:৫১ PM
 * Copyright jibon <jibon.bikash@gmail.com>
 */
?>
@extends('layouts.vertical')
@section('title', 'Applicant List')

@section('content')
    <div class="row page-title align-items-center">
        <div class="col-md-3 col-xl-6">
            <h4 class="mb-1 mt-0">Applicant List</h4>
        </div>
        <div class="col-md-9 col-xl-6 text-md-right">
            <div class="mt-4 mt-md-0">
                <a class="btn btn-primary" href="{{ route('dashboard') }}"> <i data-feather="arrow-left-circle" class="icon-dual text-white"></i> Dashboard</a>
                {{--                <button type="button" class="btn btn-danger mr-4 mb-3  mb-sm-0"><i class="uil-plus mr-1"></i> Create Project</button>--}}

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    @include('layouts.shared.message')
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Code</th>
                            <th scope="col">Roll</th>
                            <th scope="col">Applicant Name</th>
                            <th scope="col">Father's Name</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">DOB</th>
                            <th scope="col">District</th>
                            <th scope="col">Age</th>
                            <th scope="col">Quota</th>
                            <th scope="col">Action</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($applicants as $applicant)
                        <tr>
                            <th scope="row">{{ $loop->iteration + $applicants->firstItem() - 1 }}</th>
                            <td>{{ $applicant->apliyedJob ? $applicant->apliyedJob->token:'' }}</td>
                            <td>{{ $applicant->apliyedJob ? $applicant->apliyedJob->roll:'' }}</td>
                            <td>{{ $applicant->name_bn }}</td>
                            <td>{{ $applicant->father_name }}</td>
                            <td>{{ $applicant->mobile }}</td>
                            <td>{{ Carbon\Carbon::parse($applicant->bday)->format('F j, Y') }}</td>
                            <td> {{ $applicant->birthplace? $applicant->birthplace->zilla_name:'' }}</td>
                            <td>
                                <?php
                                $fixedday = Carbon\Carbon::parse($applicant->job ? $applicant->job->age_calculation : '')->format('F j, Y');
                                $fixeddaycal = date('d-m-Y', strtotime($fixedday));
                                $datetime1 = new DateTime($fixeddaycal);
                                $datetime2 = new DateTime($applicant->bday);
                                $interval = $datetime1->diff($datetime2);
                                echo $fixedday. ' তারিখে : - ';
                                echo $interval->format('%y বছর %m মাস এবং %d দিন');
                                ?>
                            </td>
                            <td>{{ $applicant->quota }}</td>
                            <td>
                                <a href="{{ route('print',$applicant->id) }}" title="Print Details" class="btn btn-sm btn-primary"><i data-feather="printer"></i></a>
                                <a href="{{ route('print',$applicant->id) }}" title="Admin Card" class="btn btn-sm btn-primary"><i data-feather="credit-card"></i></a>
                            </td>

                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $applicants->onEachSide(5)->appends(Request::all())->links('pagination::bootstrap-5') }}
                </div>
            </div>

        </div>
    </div>
    </div>


@endsection
@section('script')

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {



        });
    </script>

@endsection
