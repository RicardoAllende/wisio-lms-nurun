@extends('layouts.app')

@section('title','Reportes en excel')

@section('subtitle')
    <ol class="breadcrumb">
        <li>
          Reportes disponibles
        </li>
    </ol>
@endsection

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Reportes disponibles</h5>
                    </div>
                    <div class="ibox-content">
                      <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables">
                        <thead>
                          <tr>
                            <th>Nombre</th>
                            <th>Descargar</th>
                          </tr>
                        </thead>
                        <tbody>
                            <tr>
                              <td>Insomnio Academia</td>
                              <td><a href="{{ route('excel.report.insomnio.academia') }}" class="btn btn-primary" >Descargar</a></td>
                            </tr>
                            <tr>
                              <td>Diabetes Academia</td>
                              <td><a href="{{ route('excel.report.diabetes.academia') }}" class="btn btn-primary" >Descargar</a></td>
                            </tr>
                            <tr>
                              <td>Hipertensión Academia</td>
                              <td><a href="{{ route('excel.report.hipertension.academia') }}" class="btn btn-primary" >Descargar</a></td>
                            </tr>
                            <tr>
                              <td>Diabetes Farmacias</td>
                              <td><a href="{{ route('excel.report.diabetes.farmacia') }}" class="btn btn-primary" >Descargar</a></td>
                            </tr>
                            <tr>
                              <td>Hipertensión Farmacias</td>
                              <td><a href="{{ route('excel.report.hipertension.farmacias') }}" class="btn btn-primary" >Descargar</a></td>
                            </tr>
                        </tbody>
                      </table>
                      </div>
                    </div>
                    <div class="ibox-footer">
                      
                    </div>
                </div>
              </div>
      </div>
</div>
@endsection