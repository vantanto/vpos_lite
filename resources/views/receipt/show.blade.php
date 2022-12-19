@extends('layouts.app')
@section('style')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            .content-wrapper {
                margin: 0 !important;
                padding: 0 !important;
            }
            #section-to-print, #section-to-print * {
                visibility: visible;
            }
            #section-to-print {
                position: absolute;
                left: 0;
                top: 0;
                padding: 0;
                margin: 0;
            }
        }
    </style>
@endsection
@section('content')
<section class="content pt-3">
    <div class="container-fluid">    
        <div class="row justify-content-center">
            <div class="">
                <button type="button" id="print" class="btn btn-secondary btn-block mb-2">
                    <i class="fas fa-print"></i> Print</a>
                </button>
                <x-receipt :order="$order" />
            </div>
        </div>
      </div>
    </div>
  </section>
@endsection
@section('script')
<script>
    $(document).on('click', '#print', function() {
        window.print();
    });
</script>
@endsection