<div class="table-responsive">
    <table class="table table-hover table-bordered table-striped" id="datalistTable">
        <thead>
            <tr class="bg-light">                                                      
                {{-- Table headers --}}
                @php
                    $columns = !empty($fieldsorder) ? array_unique($fieldsorder) : $tablefield->pluck('field.name')->toArray();
                @endphp

                @foreach($columns as $col)
                    <th>{{ $col }}</th>
                @endforeach                                        
            </tr>
        </thead>

        <tbody>
            @foreach($leads as $rowSet)
                @php
                    $groupId = $rowSet['form_group_id'];
                    $leadRows    = collect($rowSet['lead'])->keyBy('field_name');
                    $meetingRows = collect($rowSet['meeting'])->keyBy('label');
                    $platform    = strtolower(optional($meetingRows->firstWhere('label', 'Platform'))->value ?? '');
                @endphp

                <tr>                                                          
                    {{-- Table cells --}}
                    @foreach($columns as $col)
                        @php
                            $leadRec    = $leadRows[$col] ?? null;
                            $meetingRec = $meetingRows[$col] ?? null;
                        @endphp

                        <td>
                            {{-- Lead Data --}}
                            @if($leadRec)
                                @if($leadRec->field_name === 'Site Name')
                                    <a href="javascript:void(0)" class="text-info viewLeadBtn" data-group="{{ $groupId }}">
                                        {{ $leadRec->field_value }}
                                    </a>
                                @elseif($leadRec->field_name === 'Lead Type')
                                    @php
                                        $type = strtolower($leadRec->field_value);
                                        $badgeClass = $type === 'private' ? 'bg-warning text-dark' : ($type === 'global' ? 'bg-success' : 'bg-secondary');
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ ucfirst($leadRec->field_value) }}</span>
                                @elseif(Str::endsWith($leadRec->field_value, ['jpg','jpeg','png','gif','webp']))
                                    <img src="{{ asset($leadRec->field_value) }}" width="50">
                                @elseif(Str::endsWith($leadRec->field_value, 'pdf'))
                                    <a href="{{ asset($leadRec->field_value) }}" target="_blank" class="btn btn-sm btn-danger">View PDF</a>
                                @else
                                    {{ $leadRec->field_value ?? '-' }}
                                @endif

                            {{-- Meeting Data --}}
                            @elseif($meetingRec)
                                @if($meetingRec->label === 'Meeting Status')
                                    <span class="badge bg-warning">{{ ucfirst($meetingRec->value) }}</span>
                                @elseif(in_array($meetingRec->label, ['Next Meeting Date','Platform']))
                                    @php
                                        $date = $meetingRec->value ?? null;
                                    @endphp
                                    
                                    @if(!empty($date) && $date != 'NULL')
                                        {{ \Carbon\Carbon::parse($date)->format('d-M-y (D)') }}
                                    @else
                                        -
                                    @endif                                                
                                    <br>
                                    <span class="badge bg-info">{{ $rowSet['meeting_count'] }}</span>
                                    @if($platform === 'desktop')
                                        <i class="fa fa-desktop text-success" title="Desktop"></i>
                                    @elseif($platform === 'mobile')
                                        <i class="fa fa-mobile-alt text-success" title="Mobile"></i>
                                    @endif
                                @else
                                    {{ $meetingRec->value ?? '-' }}
                                @endif

                            {{-- Default --}}
                            @else
                                -
                            @endif
                        </td>
                    @endforeach                                                                                                    
                </tr>
            @endforeach
        </tbody>
    </table>
</div>    