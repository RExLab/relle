<?php
// MUST be using composer
require_once '/var/www/vendor/autoload.php';
session_start();	 	

$client = new Google_Client();	 	
// Name of proj in GoogleDeveloperConsole
$client->setApplicationName("relle-analytics");

// Generated in GoogleDeveloperConsole --> Credentials --> Service Accounts
$client->setAuthConfig('/var/www/beta/relle-analytics-3753dd041a88.json');
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
<html>
<body>
<!-- Load Google's Embed API Library -->
<script>
(function(w,d,s,g,js,fs){
g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
js.src='https://apis.google.com/js/platform.js';
fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
}(window,document,'script'));
</script>

<div id="chart-1-container"></div>
<div id="chart-2-container"></div>
<div id="chart-3-container"></div>

<script>
gapi.analytics.ready(function() {

  /**
   * Authorize the user with an access token obtained server side.
   */
  gapi.analytics.auth.authorize({
    'serverAuth': {
      'access_token': '<?php print_r($myToken["access_token"]); ?>'
    }
  });
console.log(gapi.client.analytics.data.ga.get({
    'ids': 'ga:107648503', 			// THIS NEEDS TO BE A VIEW
      'start-date': '30daysAgo',		// THAT YOUR SERVICE ACCOUNT HAS
      'end-date': 'yesterday',			// ACCESS TO
      'metrics': 'ga:sessions,ga:users',
      'dimensions': 'ga:date'
  }) .then(function(response) {
    var formattedJson = JSON.stringify(response.result, null, 2);
    
  }));

  /**
   * Creates a new DataChart instance showing sessions over the past 30 days.
   * It will be rendered inside an element with the id "chart-1-container".
   */
  var dataChart1 = new gapi.analytics.googleCharts.DataChart({
    query: {
      'ids': 'ga:107648503', 			// THIS NEEDS TO BE A VIEW
      'start-date': '30daysAgo',		// THAT YOUR SERVICE ACCOUNT HAS
      'end-date': 'yesterday',			// ACCESS TO
      'metrics': 'ga:sessions,ga:users',
      'dimensions': 'ga:date'
    },
    chart: {
      'container': 'chart-1-container',
      'type': 'LINE',
      'options': {
        'width': '50%',
        'heigth': '50%'
      }
    }
  });
     var dataChart2 = new gapi.analytics.googleCharts.DataChart({
    query: {
      'ids': 'ga:107648503', 			// THIS NEEDS TO BE A VIEW
      'metrics': 'ga:sessions',
      'dimensions': 'ga:country',
      'start-date': '2015-08-01',
      'end-date': 'yesterday',
      'max-results': 10,
            'sort': '-ga:sessions'

    },
    chart: {
      container: 'chart-2-container',
      type: 'TABLE',
      options: {
        width: '20%',
      }
    }
  });
       var dataChart3 = new gapi.analytics.googleCharts.DataChart({
    query: {
      'ids': 'ga:107648503', 			// THIS NEEDS TO BE A VIEW
      'metrics': 'ga:totalEvents',
      'dimensions': 'ga:eventAction',
      'start-date': '30daysAgo',
      'end-date': 'yesterday',
      'filters': 'ga:eventCategory==Experimento'
     // 'max-results': 10,
        //    'sort': '-ga:totalEvents'

    },
    chart: {
      container: 'chart-3-container',
      type: 'PIE',
      options: {
        width: '100%',
      }
    }
  });
  dataChart1.execute();
    dataChart2.execute();
    dataChart3.execute();

});
</script>
</body>
</html>

