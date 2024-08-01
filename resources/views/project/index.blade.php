<style>
    .progress-bar {
        width: 100%;
        background-color: #e0e0e0;
        border-radius: 13px;
        overflow: hidden;
    }
    .progress-bar-fill {
        height: 20px;
        background-color: #3b2d6e;
        width: 0%;
        border-radius: 13px;
        text-align: center;
        color: white;
        line-height: 20px; /* Match the height of the bar */
    }
</style>

@foreach ($projects as $project)
    @php
        $usedTime = $time[$project->id];
        $contractedTime = $project->monthly_hours;
        $progressPercentage = ($contractedTime > 0) ? ($usedTime / $contractedTime) * 100 : 0;
    @endphp

    <div>
        <h2><abbr title="{{ $contractedTime }} hours contracted, {{ $usedTime }} hours used">{{ $project->name }}</abbr></h2>
        <div class="progress-bar">
            <div class="progress-bar-fill" style="width: {{ $progressPercentage }}%;">
                {{ number_format($progressPercentage, 2) }}%
            </div>
        </div>
    </div>
@endforeach