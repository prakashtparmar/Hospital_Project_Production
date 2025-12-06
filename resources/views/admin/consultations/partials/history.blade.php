<div>
    <h4 class="header smaller lighter blue">
        <i class="fa fa-history"></i> Patient Consultation History
    </h4>

    @if($history->count() == 0)

        <p class="text-muted">No consultations found for this patient.</p>

    @else

        <div class="accordion" id="historyAccordion">

            @foreach($history as $index => $record)

                <div class="panel panel-default">

                    <div class="panel-heading"
                         data-toggle="collapse"
                         data-target="#history-{{ $index }}"
                         style="cursor:pointer;">
                        <h5 class="panel-title">

                            <strong>
                                {{ \Carbon\Carbon::parse($record->created_at)->format('d-M-Y h:i A') }}
                            </strong>
                            —
                            Dr. {{ $record->doctor->name }}

                            <span class="badge badge-info pull-right">
                                {{ ucfirst(str_replace('_',' ', $record->status)) }}
                            </span>

                        </h5>
                    </div>

                    <div id="history-{{ $index }}" class="panel-collapse collapse">
                        <div class="panel-body">

                            {{-- ===== CONSULTATION SUMMARY ===== --}}
                            <h5 class="header smaller lighter purple">Consultation Summary</h5>

                            <table class="table table-bordered table-condensed">
                                <tr><th>Chief Complaint</th><td>{{ $record->chief_complaint ?? '—' }}</td></tr>
                                <tr><th>History</th><td>{{ $record->history ?? '—' }}</td></tr>
                                <tr><th>Examination</th><td>{{ $record->examination ?? '—' }}</td></tr>
                                <tr><th>Provisional Diagnosis</th><td>{{ $record->provisional_diagnosis ?? '—' }}</td></tr>
                                <tr><th>Final Diagnosis</th><td>{{ $record->final_diagnosis ?? '—' }}</td></tr>
                                <tr><th>Treatment Plan</th><td>{{ $record->plan ?? '—' }}</td></tr>

                                {{-- FORMATTED START/END --}}
                                <tr>
                                    <th>Consultation Started</th>
                                    <td>
                                        {{ $record->started_at ? \Carbon\Carbon::parse($record->started_at)->format('d-M-Y h:i A') : '—' }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>Consultation Ended</th>
                                    <td>
                                        {{ $record->ended_at ? \Carbon\Carbon::parse($record->ended_at)->format('d-M-Y h:i A') : '—' }}
                                    </td>
                                </tr>
                            </table>

                            {{-- ===== VITALS ===== --}}
                            <h5 class="header smaller lighter orange"><i class="fa fa-heartbeat"></i> Vitals</h5>

                            <table class="table table-bordered table-condensed">
                                <tr><th>BP</th><td>{{ $record->bp }}</td></tr>
                                <tr><th>Pulse</th><td>{{ $record->pulse }}</td></tr>
                                <tr><th>Temperature</th><td>{{ $record->temperature }}</td></tr>
                                <tr><th>Resp Rate</th><td>{{ $record->resp_rate }}</td></tr>
                                <tr><th>SPO2</th><td>{{ $record->spo2 }}</td></tr>
                                <tr><th>Weight</th><td>{{ $record->weight }}</td></tr>
                                <tr><th>Height</th><td>{{ $record->height }}</td></tr>
                            </table>

                            {{-- ===== PRESCRIPTIONS ===== --}}
                            @if($record->prescriptions->count())

                                <h5 class="header smaller lighter green">
                                    <i class="fa fa-medkit"></i> Prescriptions
                                </h5>

                                @foreach($record->prescriptions as $pr)

                                    <div class="alert alert-info" style="padding:8px;">
                                        <strong>Prescribed On:</strong>
                                        {{ $pr->prescribed_on ? \Carbon\Carbon::parse($pr->prescribed_on)->format('d-M-Y h:i A') : '—' }}
                                        <br>
                                        <strong>Notes:</strong> {{ $pr->notes ?? '—' }}
                                    </div>

                                    <table class="table table-condensed table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Drug</th>
                                                <th>Strength</th>
                                                <th>Dose</th>
                                                <th>Route</th>
                                                <th>Frequency</th>
                                                <th>Duration</th>
                                                <th>Instructions</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach($pr->items as $it)
                                                <tr>
                                                    <td>{{ $it->drug_name }}</td>
                                                    <td>{{ $it->strength }}</td>
                                                    <td>{{ $it->dose }}</td>
                                                    <td>{{ $it->route }}</td>
                                                    <td>{{ $it->frequency }}</td>
                                                    <td>{{ $it->duration }}</td>
                                                    <td>{{ $it->instructions }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>

                                @endforeach

                            @endif

                        </div>
                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>
