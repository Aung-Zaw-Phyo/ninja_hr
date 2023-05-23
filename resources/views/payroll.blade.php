@extends('layouts.app')

@section('title', 'Payroll')

@section('content')
    <div class="card mt-3">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-lg-3">
                    <input type="text" class="form-control form-control-lg employee-name" placeholder="Enter employee name ...">
                </div>
                <div class="col-lg-3">
                    <select name="" class="form-select form-control-lg select-month">
                        <option value="">------Please Choose (Month)------</option>
                        <option value="01" @if(now()->format('m') == '01') selected @endif>Jan</option>
                        <option value="02" @if(now()->format('m') == '02') selected @endif>Feb</option>
                        <option value="03" @if(now()->format('m') == '03') selected @endif>Mar</option>
                        <option value="04" @if(now()->format('m') == '04') selected @endif>Apr</option>
                        <option value="05" @if(now()->format('m') == '05') selected @endif>May</option>
                        <option value="06" @if(now()->format('m') == '06') selected @endif>Jun</option>
                        <option value="07" @if(now()->format('m') == '07') selected @endif>Jul</option>
                        <option value="08" @if(now()->format('m') == '08') selected @endif>Aug</option>
                        <option value="09" @if(now()->format('m') == '09') selected @endif>Sep</option>
                        <option value="10" @if(now()->format('m') == '10') selected @endif>Oct</option>
                        <option value="11" @if(now()->format('m') == '11') selected @endif>Nov</option>
                        <option value="12" @if(now()->format('m') == '12') selected @endif>Dec</option>
                    </select>
                </div>
                <div class="col-lg-3">
                    <select name="" class="form-select form-control-lg select-year">
                        <option value="">------Please Choose (Year)------</option>
                        @for ($i = 0; $i < 5; $i++)
                            <option class="{{ now()->subYears($i)->format('Y') }}" @if(now()->format('Y') == now()->subYears($i)->format('Y')) selected @endif>
                                {{ now()->subYears($i)->format('Y') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-lg-3">
                    <button class="btn btn-theme btn-block search-btn"><i class="fas fa-search"></i> SEARCH</button>
                </div>
            </div>


            <div class="payroll_table">

            </div>


        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $('.select-month').select2({
            placeholder: "-------Please choose (Month)-------",
            allowClear: true
        });
        $('.select-year').select2({
            placeholder: "-------Please choose (Year)-------",
            allowClear: true
        });

        const payrollTable = () => {
            let month = $('.select-month').val();
            let year = $('.select-year').val()
            let employee_name = $('.employee-name').val()
            $.ajax({
                url: `/payroll-table?employee_name=${employee_name}&month=${month}&year=${year}`,
                method: 'GET',
                success: (res) => {
                    $('.payroll_table').html(res)
                }
            })
        }

        payrollTable()

        $('.search-btn').on('click', (e) => {
            e.preventDefault()
            
            payrollTable()
        })


    })
</script>
@endsection

