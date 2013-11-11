(function($) {
/*
 * Function: fnGetColumnData
 * Purpose:  Return an array of table values from a particular column.
 * Returns:  array string: 1d data array
 * Inputs:   object:oSettings - dataTable settings object. This is always the last argument past to the function
 *           int:iColumn - the id of the column to extract the data from
 *           bool:bUnique - optional - if set to false duplicated values are not filtered out
 *           bool:bFiltered - optional - if set to false all the table data is used (not only the filtered)
 *           bool:bIgnoreEmpty - optional - if set to false empty values are not filtered from the result array
 * Author:   Benedikt Forchhammer <b.forchhammer /AT\ mind2.de>
 */
$.fn.dataTableExt.oApi.fnGetColumnData = function ( oSettings, iColumn, bUnique, bFiltered, bIgnoreEmpty ) {
    // check that we have a column id
    if ( typeof iColumn == "undefined" ) return new Array();
     
    // by default we only want unique data
    if ( typeof bUnique == "undefined" ) bUnique = true;
     
    // by default we do want to only look at filtered data
    if ( typeof bFiltered == "undefined" ) bFiltered = true;
     
    // by default we do not want to include empty values
    if ( typeof bIgnoreEmpty == "undefined" ) bIgnoreEmpty = true;
     
    // list of rows which we're going to loop through
    var aiRows;
     
    // use only filtered rows
    if (bFiltered == true) aiRows = oSettings.aiDisplay;
    // use all rows
    else aiRows = oSettings.aiDisplayMaster; // all row numbers
 
    // set up data array   
    var asResultData = new Array();
     
    for (var i=0,c=aiRows.length; i<c; i++) {
        iRow = aiRows[i];
        var aData = this.fnGetData(iRow);
        var sValue = aData[iColumn];
         
        // ignore empty values?
        if (bIgnoreEmpty == true && sValue.length == 0) continue;
 
        // ignore unique values?
        else if (bUnique == true && jQuery.inArray(sValue, asResultData) > -1) continue;
         
        // else push the value onto the result data array
        else asResultData.push(sValue);
    }
     
    return asResultData;
}}(jQuery));
 
 
function fnCreateSelect( aData )
{
    var r='<option value=""></option>', i, iLen=aData.length;
    for ( i=0 ; i<iLen ; i++ )
    {
        r += '<option value="'+aData[i]+'">'+aData[i]+'</option>';
    }
    return r;
}

$.fn.dataTableExt.oApi.fnVisibleToColumnIndex = function ( oSettings, iMatch )
{
    return oSettings.oApi._fnVisibleToColumnIndex( oSettings, iMatch );
};



$(function() {
	$("#from").datepicker({ 
		defaultDate:"-1M",
		dateFormat: "M d, yy",
		maxDate:"+0D",  
		onClose: function( selectedDate ) {
			$( "#to" ).datepicker( "option", "minDate", selectedDate );
		} 
	});
	$("#to").datepicker({ 
		maxDate:"+0D",
		dateFormat: "M d, yy",
		defaultDate: "+0D",
		onClose: function( selectedDate ) {
			$( "#from" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
	
	var oTable = $(".datatable").dataTable({
		"bPaginate":false, 
		"fnDrawCallback": function ( oSettings ) {
			/* Need to redo the counters if filtered or sorted */
			if ( oSettings.bSorted || oSettings.bFiltered )
			{
				for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
				{
					$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1 );
				}
			}
		},
		"aoColumnDefs": [
			{ "bSortable": false, "aTargets": [ 0 ] }
		],
		"aaSorting": [[ 1, 'asc' ]], 
		"oTableTools": {
            "sSwfPath": "js/datatables/extras/TableTools/media/swf/copy_csv_xls_pdf.swf",
			"aButtons": [
				{
					"sExtends": "copy",
					"sButtonClass": "btn btn-primary",
					"mColumns": "visible"
				},
				{
					"sExtends": "csv",
					"sButtonClass": "btn btn-info",
					"mColumns": "visible"
				},
				{
					"sExtends": "print",
					"sButtonClass": "btn btn-success",
					"mColumns": "visible"
				}
			]
        }, 
		"sDom": 'lfrtipTC', // todo - add column selector back in when finished styling 
		/*"sDom": 'lfrtipT',*/
		"oColVis": {
			/*"activate": "mouseover", */
			"aiExclude": [ 0 ],
			"bCssPosition": true,
			"fnLabel": function ( index, title, th ) {
				// strip out anything other than text (ie filter form elements)
				if (title.indexOf('<') === -1) return title;
				else return title.substr(0, title.indexOf('<'));
			}
		}
	});
	
	// Set up the select element filtering
    $(".select-filter").each( function ( i ) {
		var col = oTable.oApi._fnVisibleToColumnIndex(oTable.fnSettings(), $(this).closest("th").index());
        this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(col) );
        $(this).change( function () {
            oTable.fnFilter( $(this).val(), col);
        } );
    } );
	
	// Set up the input field filtering
	
	$(".input-filter").keyup( function () {		
		var col = oTable.oApi._fnVisibleToColumnIndex(oTable.fnSettings(), $(this).closest("th").index());
        oTable.fnFilter( this.value, col );
    });
	
	// Make blur work in case click/change didn't
	/*$(".input-filter, .select-filter").blur( function () {
		var col = $(this).closest("th").index();
        oTable.fnFilter( this.value, col );
    });*/
	
	// stop the clicking of the form elements from ordering the table
	$(".input-filter, .select-filter").click(function(e) {
		e.stopPropagation();												  
	});
	
	// automatically hide some colunns
	$(".datatable th").each(function(i) {
		// automatically hide columns that have a class of 'hide'
		if ($(this).hasClass('initially-hidden')) {
			oTable.fnSetColumnVis( i, false );
		}
	});
	
	// automatically hide some colunns
	$(".client-report th").each(function(i) {
		var name = $(this).html();
		if (name.match('^Entered By')) {
			oTable.fnSetColumnVis( i+1, false ); // no idea why needs to be +1
		}
	});
	
	// add a class to the colunn select button for easy styling
	$(".ColVis_MasterButton").addClass('btn dropdown-toggle').append(' <span class="caret"></span>');
	

	// move the pdf button inside the same container as the ones generated by datatables
	$("#pdf_form").appendTo($(".DTTT_container"));

	$("#pdf_btn").click(function(e) {
		e.preventDefault();
		var html = $("#DataTables_Table_0").html();
		$("#pdf_html").val(html);
		$("#pdf_form").submit();
	});

	$('.device-name').tooltip({ placement:'left' });
	
});

