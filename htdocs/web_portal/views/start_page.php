<div class="rightPageContainer">
    <h1 class="startPage">
      Welcome to GOCDB
      <img src="img/eosc_logo_thin.png" alt="The logo of the EOSC" height="70">
      <img src="/images/logos/eosc_future.png" alt="The logo of the EOSC Future Horizon 20 20 project" height="70">
    </h1>
    <div class="start_page_body">
    GOCDB is the official repository for storing and presenting topology and
    resources information for the Beta EOSC Core, deployed by EOSC-hub.

    <br/><br/>

    <h2 class="startPage">What information is stored here?</h2>
    <br />

    The GOCDB data consists mainly of:
    <ul>
    <li class="no_border">Resource Providers providing the infrastructure</li>
    <li class="no_border">Resources and services, including maintenance plans for these resources</li>
    <li class="no_border">Participating people, and their roles within the infrastructure.</li>
    </ul>
   Data are provided and updated by the community,
   and are presented through this web portal.<br/><br/>

   For a list of services in the infrastructure, see
   <a href="index.php?Page_Type=Services">here</a>.<br/><br/>

        Please note:
        <ul>
          <li>It is a "catch-all" service. This means it is centrally hosted on behalf of the infrastructure.</li>
          <li>If an organisation deploys and uses their own system or a local GOCDB installation, their data won't appear here.</li>
        </ul>

</div>

    <?php if(sizeof($params['roles']) > 0) { ?>
        <div class="alert alert-warning" style="width: 98%; margin-bottom:1%; float: left;">
                <span class="glyphicon glyphicon-asterisk"></span>   <b>Notification:</b> You have pending role requests - <a href="index.php?Page_Type=Role_Requests">Manage Roles</a>
        </div>
    <?php } ?>

    <!-- map Block -->
    <?php if($params['showMap']): ?>
      <!-- Use a web based leaflet.js to avoid distributing leaflet.js. -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.4.0/leaflet.css" integrity="sha256-YR4HrDE479EpYZgeTkQfgVJq08+277UXxMLbi/YP69o=" crossorigin="anonymous" />
      <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.4.0/leaflet.js" integrity="sha256-6BZRSENq3kxI4YYBDqJ23xg0r1GwTHEpvp3okdaIqBw=" crossorigin="anonymous"></script>
      <script type="text/javascript" src="javascript/leafletembed.js"></script>
      <div id="map" style="width:100%;height:400px;"><body onload="initmap()"></div>
    <?php endif; ?>
</div>
