<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(__('reports.type_detail')); ?></title>

    <style>

        @page {
            size: A4 landscape;
          /*  margin: 20px;*/
            margin-top: 120px;
        }

        @font-face {
            font-family: 'DejaVu Sans';
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
        }
        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            /*border: 1px solid black;*/
            margin-top: 10px;
        }

        th, td {
            border: 1px solid black;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr {
            /*border: 1px solid black;*/
        }

        .text-left {
            text-align: left;
        }

        .total-row {
            font-weight: bold;
            background-color: #f2f2f2;
        }
        .desc {
            margin: 15px auto;
            /*border: 1px solid #ddd;*/
            /*padding: 15px;*/
            /*border-radius: 5px;*/
            /*background: #f9f9f9;*/
        }

        .header {
            margin-left: 5px;
        }
        .header_sub {
            color: #a8a8a8;
            margin-left: 10px;
        }
        .footer_sub {
            color: #a8a8a8;
            margin-left: 10px;
        }
        .title_report {
            text-transform: uppercase;
            font-weight: bold;
            margin-left: 10px;
            margin-bottom: 5px;
        }
        .line {
            height: 1px;
            background-color: #a8a8a8;
            margin: 7px;
        }
        .row {
            display: flex; /* Gi postavuva row_left i row_right eden do drug */
            /*border-bottom: 1px solid #ddd;*/
            padding: 1px 0;
            margin-left: 10px;
            align-items: center;
        }
        .row_left {
            float: left;
            width: auto;
            font-weight: bold;
            padding-right: 5px;

        }
        .row_right {

            font-weight: bold;
            width: auto;

        }

        .desc_f {
            margin: 15px auto;
            /*border: 1px solid #ddd;*/
            /*padding: 15px;*/
            /*border-radius: 5px;*/
            /*background: #f9f9f9;*/
        }
        .row_f {
            display: flex; /* Gi postavuva row_left i row_right eden do drug */
            /*border-bottom: 1px solid #ddd;*/
            padding: 1px 0;
            margin-left: 10px;
            /*align-items: center;*/
        }
        .row_left_f {
            float: left;
            width:60%;
            font-weight: bold;
            padding-right: 5px;
            text-align: right;

        }
        .row_right_f {

            font-weight: bold;
            width: auto;
            padding-right: 5px;

        }
        .gray {

           color: #a8a8a8;
        }
        .red {

            color: #b70000;
        }
        .orange {

            color: #e87d06;
        }

        header{
            position: fixed;
            left: 0px;
            right: 0px;
            height: 150px;
            margin-top: -90px;
        }
        footer{
            position: fixed;
            left: 0px;
            right: 0px;
            height: 150px;
            bottom: 0px;
            margin-bottom: -150px;
        }
    </style>
    <script type="text/php">
        if ( isset($pdf) ) {
            $font = Font_Metrics::get_font("helvetica", "bold");
            $pdf->page_text(72, 18, "Header: {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0,0,0));
        }
    </script>
</head>
<body>
<header>
    <div class="header">
        <img src="<?php echo e(public_path('/uploads/_images/cnvp_logo_small.png')); ?>" />
    </div>

    <div class="header_sub"><?php echo e(config('app.URL')); ?></div>

    <div class="line"></div>
</header>
<footer>
    <div class="line"></div>
    <div class="footer_sub"><?php echo e(config('app.URL')); ?></div>

</footer>

<main>

<div class="desc">
    <div class="title_report"><?php echo e(__('reports.title_report_detail')); ?></div>

    <div class="row">
        <div class="row_left">
            <?php echo e(__('reports.id_user')); ?>:
        </div>
        <div class="row_right orange">
            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo e($user->name); ?>  <?php echo e($user->surname); ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>


    <div class="row">
        <div class="row_left">
            <?php echo e(__('reports.period')); ?>:
        </div>
        <div class="row_right orange">
            <?php echo e($date1); ?> - <?php echo e($date2); ?>

        </div>
    </div>

    <?php
        $monthNumber = request()->query('month');
        $months = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
        ];
    ?>

    <?php if($monthNumber): ?>
        <div class="row">
            <div class="row_left red">
                <?php echo e(__('reports.period_month')); ?>:
            </div>
            <div class="row_right orange">
                <?php echo e($months[$monthNumber]); ?>

            </div>
        </div>
    <?php endif; ?>

    <div class="row"><strong><?php echo e(__('reports.projects')); ?>:</strong></div>
    <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="row">
        <strong class="gray">
            <span class="orange"><?php echo e($project->name); ?></span>  (<?php echo e($project->description); ?>)

        </strong>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


</div>


<table>
    <thead>
    <tr>

        <th><?php echo e(__('reports.id_user')); ?></th>
		<th><?php echo e(__('reports.year')); ?></th>--}}
        <th><?php echo e(__('reports.id_country')); ?></th>
        <th><?php echo e(__('reports.project')); ?></th>
        <th><?php echo e(__('reports.assignment')); ?></th>
        <th><?php echo e(__('reports.activity')); ?></th>
        <th><?php echo e(__('reports.duration_s')); ?></th>
        <th><?php echo e(__('reports.date')); ?></th>


    </tr>
    </thead>
    <tbody>
    <?php $total = 0; ?>
    <?php $__currentLoopData = $records; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $total += $record->duration;
            $record_assignments_name = $record->assignments->name ?? 'n/a';
            $record_activities_name = $record->activities->name ?? 'n/a';
        ?>
        <tr  <?php if($record->activities->type==1): ?> style="color: #BD362F" <?php endif; ?> >

            <td><?php echo e($record->insertedByUser->name); ?> <?php echo e($record->insertedByUser->surname); ?></td>
            <td><?php echo e($record->year); ?></td>--}}
            <td><?php echo e($record->countries->name); ?></td>
            <td><?php echo e($record->projects->name); ?></td>
            <td><?php echo e($record_assignments_name); ?></td>
            <td><?php echo e($record_activities_name); ?></td>
            <td><?php echo e($record->duration); ?></td>
            <td><?php echo e(date("d.m.Y", strtotime($record->date))); ?></td>











        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <tr class="total-row">
        <td colspan="6"  style="text-align: right;"><strong><?php echo e(__('reports.total')); ?>:</strong></td>
        <td><?php echo e($total); ?></td>
 <td colspan="1"></td>
    </tr>
    </tbody>
</table>


<div class="desc_f">

    <div class="row_f">
        <div class="row_left_f">
       <?php echo e(__('reports.total_hours')); ?>:
        </div>
        <div class="row_right_f">
            <?php echo e($total); ?>

        </div>
    </div>


    <?php $total_non_working = 0; ?>
    <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $total_non_working += $activityDurations[$activity->id] ?? 0;
        ?>
    <div class="row_f">
        <div class="row_left_f gray">
            <?php echo e(__('reports.total')); ?>   <?php echo e($activity->name); ?>:
        </div>
        <div class="row_right_f gray">
            <?php echo e($activityDurations[$activity->id] ?? 0); ?>

        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <div class="row_f">
        <div class="row_left_f">
            <?php echo e(__('reports.total_working_hours')); ?>:
        </div>
        <div class="row_right_f ">
            <?php echo e($total-$total_non_working); ?>

        </div>
    </div>

    <div class="line"></div>

    <div class="row_f">
        <div class="row_left_f">
            <?php echo e(__('reports.total_working_hours_for_all_projects')); ?>:
        </div>
        <div class="row_right_f ">
            <?php echo e($totalDurationWithoutProjectFilter); ?>

        </div>
    </div>
    <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(($projectDurations[$project->id]?? 0) >0): ?>
        <div class="row_f">
            <div class="row_left_f gray">
                <?php echo e(__('reports.total_working_hours_on')); ?> <span class="orange"><?php echo e($project->name); ?></span>:
            </div>
            <div class="row_right_f gray" style="float: left">
                <?php echo e($projectDurations[$project->id] ?? 0); ?>

            </div>
            <div class="row_right_f red">
                (<?php echo e(number_format(($projectDurations[$project->id] ?? 0) / ($totalDurationWithoutProjectFilter) * 100, 2)); ?> %)
            </div>
        </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</div>



<div class="line"></div>


<div class="desc">


    <div class="row">
        <div class="row_left">
            <?php echo e(__('reports.submitted_by')); ?>:
        </div>
        <div class="row_right gray" style="margin-right: 20px;float: left">

            <?php echo e($user->name); ?>  <?php echo e($user->surname); ?>

        </div>

        <div class="row_left">
            <?php echo e(__('reports.approved_by')); ?>: ____________________________________________
        </div>
















    </div>

</div>


</main>
</body>
</html>
<?php /**PATH /var/www/Modules/Reports/resources/views/reports/pdf-detail.blade.php ENDPATH**/ ?>