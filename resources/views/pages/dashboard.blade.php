<?php
// MUST be using composer
require_once '/var/www/relle/vendor/autoload.php';
session_start();

$client = new Google_Client();
// Name of proj in GoogleDeveloperConsole
$client->setApplicationName("relle-analytics");

// Generated in GoogleDeveloperConsole --> Credentials --> Service Accounts
$client->setAuthConfig('/var/www/relle/relle-analytics-3753dd041a88.json');
$client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);

// Grab token if it's set 
if (isset($_SESSION['service_token'])) {
    $client->setAccessToken($_SESSION['service_token']);
}

// Refresh if expired
if ($client->isAccessTokenExpired()) {
    $client->refreshTokenWithAssertion();
}

// Pin to Session
$_SESSION['service_token'] = $client->getAccessToken();

$myToken = $client->getAccessToken();
?>
@extends('layout.dashboard')

@section('page')
{{trans('interface.name', ['page'=>trans('dashboard.title')])}}
@stop

@section('inside')
{{Analytics::trackEvent('Página', 'Dashboard')}}

<script>
(function(w,d,s,g,js,fs){
  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
  js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
  js.src='https://apis.google.com/js/platform.js';
  fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
}(window,document,'script'));
</script>
<style>
    .cardBottom{
        margin-bottom: 30px;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="content-box-header" >
            <div class="panel-title"> {{trans("log.map")}}</div>
        </div>
        <div class="content-box-large box-with-header cardBottom">
                <div id="chart-2-container"></div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="content-box-header" >
            <div class="panel-title"> {{trans("log.accessMonth")}}</div>
        </div>
        <div class="content-box-large box-with-header cardBottom" style="padding: 1">
                <div id="chart-1-container"></div>
        </div>
    </div>
    <center>
        <div class="col-md-6">
            <div class="content-box-header">
                <div class="panel-title">{{trans("log.labsAccess")}} </div>
            </div>
            <div class="content-box-large box-with-header cardBottom">
                    <div id="chart-3-container"></div>
            </div>
        </div>
    </center>
    <center>

        <div class="col-md-6">
            <div class="content-box-header">
                <div class="panel-title"> {{trans("log.pagesAccess")}}</div>
            </div>
            <div class="content-box-large box-with-header cardBottom">
                    <div id="chart-4-container"></div>
            </div>
        </div>
    </center>  
</div>
@stop
@section('script_dash')
<script>
    gapi.analytics.ready(function () {

        /**
         * Authorize the user with an access token obtained server side.
         */
        gapi.analytics.auth.authorize({
            'serverAuth': {
                'access_token': '<?php print_r($myToken["access_token"]); ?>'
            }
        });

        /* Creates a new DataChart instance showing sessions over the past 30 days.
         * It will be rendered inside an element with the id "chart-1-container".
         */
        var dataChart1 = new gapi.analytics.googleCharts.DataChart({
            query: {
                'ids': 'ga:107648503', // THIS NEEDS TO BE A VIEW
                'start-date': '30daysAgo', // THAT YOUR SERVICE ACCOUNT HAS
                'end-date': 'today', // ACCESS TO
                'metrics': 'ga:sessions,ga:users',
                'dimensions': 'ga:date'
            },
            chart: {
                'container': 'chart-1-container',
                'type': 'LINE',
                'options': {
                    'width': '10%',
                    'heigth': '10%'
                }
            }
        });
        var dataChart2 = new gapi.analytics.googleCharts.DataChart({
            query: {
                'ids': 'ga:107648503', // THIS NEEDS TO BE A VIEW
                'metrics': 'ga:sessions',
                'dimensions': 'ga:country',
                'start-date': '2015-08-01',
                'end-date': 'today',
            },
            chart: {
                container: 'chart-2-container',
                type: 'GEO',
                options: {
                    width: '20%',
                }
            }
        });
        var dataChart3 = new gapi.analytics.googleCharts.DataChart({
            query: {
                'ids': 'ga:107648503', // THIS NEEDS TO BE A VIEW
                'metrics': 'ga:totalEvents',
                'dimensions': 'ga:eventAction',
                'start-date': '2015-08-01',
                'end-date': 'today',
                'filters': 'ga:eventCategory==Experimento;ga:eventAction!=AC Electric Panel;ga:eventAction!=teste!=Painel Elétrico CC 2'
            },
            chart: {
                container: 'chart-3-container',
                type: 'PIE',
                options: {
                    width: '100%',
                }
            }
        });
        var dataChart4 = new gapi.analytics.googleCharts.DataChart({
            query: {
                'ids': 'ga:107648503', // THIS NEEDS TO BE A VIEW
                'metrics': 'ga:totalEvents',
                'dimensions': 'ga:eventAction',
                'start-date': '30daysAgo',
                'end-date': 'today',
                'filters': 'ga:eventCategory==Página'
            },
            chart: {
                container: 'chart-4-container',
                type: 'PIE',
                options: {
                    width: '100%',
                }
            }
        });
        dataChart1.execute();
        dataChart2.execute();
        dataChart3.execute();
        dataChart4.execute();
    });
</script>
@stop
