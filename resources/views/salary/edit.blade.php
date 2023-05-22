@extends('layouts.app')

@section('title', 'Edit Salary')

@section('content')
    <div>
        <form action="{{ route('salary.update', $salary->id) }}" autocomplete="off" id="create-salary" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-lg-12">
                            <div class="form-group mb-4">
                                <label for="" class="form-label">Employee</label>
                                <select type="text" name="user_id" id="employee_id" class="form-select form-control-lg select-employee">
                                    <option value="" class="text-muted" >Please choose employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}" @if ($employee->id == old('user_id', $salary->user_id)) selected @endif>{{ $employee->employee_id }} ({{ $employee->name }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-4">
                                <label for="" class="form-label">Month</label>
                                <select name="month" class="form-select form-control-lg select-month">
                                    <option value="">------Please Choose (Month)------</option>
                                    <option value="01" @if($salary->month == '01') selected @endif>Jan</option>
                                    <option value="02" @if($salary->month == '02') selected @endif>Feb</option>
                                    <option value="03" @if($salary->month == '03') selected @endif>Mar</option>
                                    <option value="04" @if($salary->month == '04') selected @endif>Apr</option>
                                    <option value="05" @if($salary->month == '05') selected @endif>May</option>
                                    <option value="06" @if($salary->month == '06') selected @endif>Jun</option>
                                    <option value="07" @if($salary->month == '07') selected @endif>Jul</option>
                                    <option value="08" @if($salary->month == '08') selected @endif>Aug</option>
                                    <option value="09" @if($salary->month == '09') selected @endif>Sep</option>
                                    <option value="10" @if($salary->month == '10') selected @endif>Oct</option>
                                    <option value="11" @if($salary->month == '11') selected @endif>Nov</option>
                                    <option value="12" @if($salary->month == '12') selected @endif>Dec</option>
                                </select>
                            </div>
                            <div class="form-group mb-4">
                                <label for="" class="form-label">Year</label>
                                <select name="year" class="form-select form-control-lg select-year">
                                    <option value="">------Please Choose (Year)------</option>
                                    @for ($i = 0; $i < 10; $i++)
                                        <option value="{{ now()->addYears(5)->subYears($i)->format('Y') }}" @if($salary->year == now()->addYears(5)->subYears($i)->format('Y')) selected @endif>
                                            {{ now()->addYears(5)->subYears($i)->format('Y') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="form-group mb-4">
                                <label for="" class="form-label">Amount</label>
                                <input type="number" name='amount' class="form-control form-control-lg" placeholder="Amount (MMK)" value="{{ old('amount', $salary->amount) }}">
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

{!! JsValidator::formRequest('App\Http\Requests\UpdateSalary', '#edit-salary') !!}
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

