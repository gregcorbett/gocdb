<?php
$name = $params['Name'];
$id = $params['ID'];
$description = $params['Description'];
$ngis = $params['NGIs'];
$ngiCount = count($ngis);
$reserved = $params['Reserved'];
$sites = $params['Sites'];
$siteCount = count($sites);
$serviceGroups = $params['ServiceGroups'];
$serviceGroupsCount = count($serviceGroups);
$services = $params['Services'];
$serviceCount = count($services);
$totalCount = $siteCount + $ngiCount + $serviceCount +$serviceGroupsCount;
?>

<div class="rightPageContainer">

    <!--Headings-->
    <div style="float: left; width: 50em;">
        <h1 style="float: left; margin-left: 0em;">Scope: <?php echo $name?></h1>
        <span style="clear: both; float: left; padding-bottom: 0.4em;"><?php echo $description ?></span>
        <span style="clear: both; float: left; padding-bottom: 0.4em;">
            This scope is <?php echo(($reserved) ? 'reserved' : 'not reserved') ?>.
        </span>
        <span style="clear: both; float: left; padding-bottom: 0.4em;">
            <?php if($totalCount>0):?>
                In total, there are <?php if($totalCount==1){echo "is";}else{echo "are";}?>
                <?php if ($totalCount == 0){echo "no";} else{echo $totalCount;} ?>
                entit<?php if($totalCount != 1){echo "ies";}else{echo "y";}?>
                (<?php echo $ngiCount?> NGIs, <?php echo $siteCount?> sites, <?php echo $serviceGroupsCount?>
                service groups, and <?php echo $serviceCount?> services) with this scope.
            <?php else: ?>
                This scope is currently not used by any NGI, site, service group, or service.
            <?php endif; ?>
        </span>

    </div>

    <!--Edit/Delete buttons-->
    <!-- don't display in read only mode or if user is not admin -->
    <?php if(!$params['portalIsReadOnly'] && $params['UserIsAdmin']):?>
        <div style="float: right;">
            <div style="float: right; margin-left: 2em;">
                <a href="index.php?Page_Type=Admin_Edit_Scope&amp;id=<?php echo $id ?>">
                    <img src="<?php echo \GocContextPath::getPath()?>img/pencil.png" class="pencil" />
                    <br />
                    <br />
                    <span>Edit</span>
                </a>
            </div>
            <div style="float: right;">
                <script type="text/javascript" src="<?php echo \GocContextPath::getPath()?>javascript/confirm.js"></script>
                <a onclick="return confirmSubmit()"
                   href="index.php?Page_Type=Admin_Remove_Scope&id=<?php echo $id?>">
                    <img src="<?php echo \GocContextPath::getPath()?>img/trash.png" class="trash" />
                    <br />
                    <br />
                    <span>Delete</span>
                </a>
            </div>
        </div>
    <?php endif; ?>

    <script>
        $(document).ready(function()
            {
                // sort on first and second table cols only (we start counting zero)
                $("#selectedNgisTable").tablesorter({
                    headers: {
                    // don't sort on the 0th column
                    0: {
                        sorter: false
                    }
                    }
                });
            }
        );
    </script>

    <!--  NGIs -->
    <div class="listContainer">
        <span class="header listHeader">
            There <?php if($ngiCount==1){echo "is";}else{echo "are";}?> <?php if ($ngiCount == 0){echo "no";} else{echo $ngiCount;} ?> NGI<?php if($ngiCount != 1) echo "s"?> with this scope
        </span>

        <img src="<?php echo \GocContextPath::getPath()?>img/ngi.png" class="decoration" />

        <?php if ($ngiCount != 0): ?>
            <table id="selectedNgisTable" class="table table-striped table-condensed tablesorter">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($params['NGIs'] as $ngi) {
                    ?>
                    <tr>
                        <td style="width: 10%">
                            <img class="flag" style="vertical-align: middle" src="<?php echo \GocContextPath::getPath()?>img/ngi/<?php echo $ngi->getName() ?>.jpg">
                        </td>
                        <td>
                            <a href="index.php?Page_Type=NGI&amp;id=<?php echo $ngi->getId() ?>">
                                <?php xecho($ngi->getName()); ?>
                            </a>
                        </td>
                        <td><?php xecho($ngi->getDescription()) ?></td>
                    </tr>
                    <?php
                    } // End of the foreach loop iterating over NGIs
                    ?>
                </tbody>

            </table>
        <?php else: echo "<br><br>&nbsp &nbsp"; endif; ?>
    </div>

    <script>
        $(document).ready(function()
            {
            // sort on first and second table cols only
                $("#selectedSETable").tablesorter({});
            }
        );
    </script>

    <!--  Sites -->
    <div class="listContainer">
        <span class="header listHeader">
            There <?php if($siteCount==1){echo "is";}else{echo "are";}?> <?php if ($siteCount == 0){echo "no";} else{echo $siteCount;} ?> site<?php if($siteCount != 1) echo "s"?> with this scope
        </span>
        <img src="<?php echo \GocContextPath::getPath()?>img/site.png" class="decoration" />
        <?php if($siteCount > 0): ?>
            <table class="table table-striped table-condensed tablesorter"" id="selectedSETable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Certification Status</th>
                        <th>Production Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($params['Sites'] as $site) {
                    ?>
                    <tr>
                        <td>
                            <a href="index.php?Page_Type=Site&amp;id=<?php echo $site->getId() ?>">
                                <?php xecho($site->getShortName()); ?>
                            </a>
                        </td>
                        <td>
                            <?php xecho($site->getCertificationStatus()->getName()) ?>
                        </td>
                        <td>
                            <?php xecho($site->getInfrastructure()->getName()) ?>
                        </td>
                    </tr>
                    <?php
                    } // End of the foreach loop iterating over Sites
                    ?>
                </tbody>
            </table>
        <?php endif;?>
    </div>

    <script>
        $(document).ready(function()
            {
                $("#selectedServiceGroupTable").tablesorter({});
            }
        );
    </script>

    <!--  Service Groups -->
    <div class="listContainer">
        <span class="header listHeader">
            There <?php if($serviceGroupsCount==1){echo "is";}else{echo "are";}?> <?php if ($serviceGroupsCount == 0){echo "no";} else{echo $serviceGroupsCount;} ?> service group<?php if($serviceGroupsCount != 1) echo "s"?> with this scope
        </span>
        <img src="<?php echo \GocContextPath::getPath()?>img/virtualSite.png" class="decoration" />
        <?php if($serviceGroupsCount>0): ?>
            <table class="table table-striped table-condensed tablesorter" id="selectedServiceGroupTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach($serviceGroups as $sGroup) {
                    ?>
                        <tr>
                            <td>
                                <a href="index.php?Page_Type=Service_Group&amp;id=<?php echo $sGroup->getId()?>">
                                    <?php xecho($sGroup->getName()); ?>
                                </a>
                            </td>
                            <td>
                                <?php xecho($sGroup->getDescription()); ?>
                            </td>
                        </tr>
                    <?php
                        } // End of the foreach loop iterating over Service Groups
                    ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <!--  Services - count and link -->
    <div class="listContainer">
        <span class="header listHeader">
            There <?php if($serviceCount==1){echo "is";}else{echo "are";}?> <?php if ($serviceCount == 0){echo "no";} else{echo $serviceCount;} ?> service<?php if($serviceCount != 1) echo "s"?> with this scope
        </span>
        <img src="<?php echo \GocContextPath::getPath()?>img/service.png" class="decoration" />
        <?php if($serviceCount>0): ?>
            <table class="vSiteResults">
                <tr class="site_table_row_1">
                    <td class="site_table">
                        <a href="index.php?Page_Type=Services&amp;mscope[]=<?php xecho($name)?>">
                            View Services
                        </a>
                    </td>
                </tr>
            </table>
        <?php endif; ?>
    </div>
</div>
