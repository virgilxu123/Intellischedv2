@extends('layouts.layout')
@section('content')
    <div class="container-fluid">
        <div class="row animate__animated animate__fadeIn">
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">WORKLOAD SUMMARY</strong>
                    </div>
                    <div class="card-body">
                        <table
                            class="table table-striped table-bordered"
                            id="table"
                            data-toolbar="#toolbar"
                            data-toggle="table"
                            data-pagination="true"
                            data-pagination-h-align="left"
                            data-pagination-detail-h-align="right"
                            data-pagination-v-align="bottom"
                            data-search="true"
                            data-searchable="true">
                            <thead class="table-dark">
                                <tr>
                                    <th data-sortable="true">Academic Year</th>
                                    <th data-sortable="true">Term</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($academicYearTerms as $academicYearTerm)
                                    <tr>
                                        <td>
                                            {{$academicYearTerm->academic_year->year_start}} - {{$academicYearTerm->academic_year->year_start + 1}}
                                        </td>
                                        <td>
                                            {{$academicYearTerm->term->term}}
                                        </td>
                                        <td class="text-center">
                                            <form action="{{route('view-work-load-summary',['academicYearTerm'=>$academicYearTerm->id])}}" method="POST" target="__blank" class="d-inline">
                                                @csrf
                                                <button class="btn btn-danger btn-sm py-0 px-1"  data-toggle="tooltip"  data-placement="top" title="View PDF" style="cursor: pointer"><i class="fa-solid fa-file-pdf"></i></button>
                                            </form>
                                            <form action="" method="POST" target="__blank" class="d-inline">
                                                @csrf
                                                <button class="btn btn-success btn-sm py-0 px-1"  data-toggle="tooltip" data-placement="top" title="Download Excel"  style="cursor: pointer"><i class="fa-solid fa-file-excel"></i></button>
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
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#table tbody').on('click', 'fa-file-pdf ', function(e) {

            });
        });
    </script>
@endsection