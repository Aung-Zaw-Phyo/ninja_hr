@extends('layouts.app')

@section('title', 'Create Salary')

@section('content')
    <div>
        <form action="{{ route('salary.store') }}" autocomplete="off" id="create-salary" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-lg-12">
                            <div class="form-group mb-4">
                                <label for="" class="form-label">Employee</label>
                                <select type="text" name="user_id" id="employee_id" class="form-select form-control-lg select-employee">
                                    <option value="" class="text-muted" >Please choose employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->employee_id }} ({{ $employee->name }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-4">
                                <label for="" class="form-label">Month</label>
                                <select name="month" class="form-select form-control-lg select-month">
                                    <option value="">------Please Choose (Month)------</option>
                                    <option value="01">Jan</option>
                                    <option value="02">Feb</option>
                                    <option value="03">Mar</option>
                                    <option value="04">Apr</option>
                                    <option value="05">May</option>
                                    <option value="06">Jun</option>
                                    <option value="07">Jul</option>
                                    <option value="08">Aug</option>
                                    <option value="09">Sep</option>
                                    <option value="10">Oct</option>
                                    <option value="11">Nov</option>
                                    <option value="12">Dec</option>
                                </select>
                            </div>
                            <div class="form-group mb-4">
                                <label for="" class="form-label">Year</label>
                                <select name="year" class="form-select form-control-lg select-year">
                                    <option value="">------Please Choose (Year)------</option>
                                    @for ($i = 0; $i < 10; $i++)
                                        <option value="{{ now()->addYears(5)->subYears($i)->format('Y') }}" >
                                            {{ now()->addYears(5)->subYears($i)->format('Y') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group mb-4">
                                <label for="" class="form-label">Amount</label>
                                <input type="number" name='amount' class="form-control form-control-lg" placeholder="Amount (MMK)">
                            </div>
                        </div>
                        <div class="col-lg-6 mx-auto">
                            <button type="submit" class="btn btn-theme btn-block">CONFIRM</button>
                        </div>
                    </div>
                </div>
            </div>
            
            

        </form>
    </div>
@endsection

@section('script')

{!! JsValidator::formRequest('App\Http\Requests\StoreSalary', '#create-salary') !!}
<script>
    $(document).ready(function () {
        $('.select-employee').select2({
            placeholder: "-------Please choose employee-------",
            allowClear: true
        });
        $('.select-month').select2({
            placeholder: "-------Please choose (Month)-------",
            allowClear: true
        });
        $('.select-year').select2({
            placeholder: "-------Please choose (Year)-------",
            allowClear: true
        });
    })
</script>
@endsection

