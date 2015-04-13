<script type="text/javascript">
//////////////////////////////////////////////////////////////// BEGIN DATATABLE ////////////////////////////////////////////////////////////////
               $(document).ready(function() {
                  $('#resumen1').dataTable
                  ( 
                    {
                        // scrollY: 300,

                        sDom: '"top"i',
                        paging:   true,
                        ordering: true,
                        info:     false,
                        order: [[ 1, "asc" ]],
                        sPaginationType: "full_numbers",
                        'footerCallback': function ( row, data, start, end, display ) 
                        {
                            var api = this.api(), data;

                            // Remove the formatting to get integer data for summation
                            var intVal = function ( i ) {
                                return typeof i === 'string' ?
                                    i.replace(/[\$,]/g, '')*1 :
                                    typeof i === 'number' ?
                                        i : 0; };

                            // Total over all pages
                            data = api.column( 2 ).data(); debe = data.length ? data.reduce( function (a, b) { return intVal(a) + intVal(b); } ) :0;
                                $( api.column( 2 ).footer() ).html(debe.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") );
                            data = api.column( 3 ).data(); debe = data.length ? data.reduce( function (a, b) { return intVal(a) + intVal(b); } ) :0;
                                $( api.column( 3 ).footer() ).html(debe.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") );
                            data = api.column( 4 ).data(); debe = data.length ? data.reduce( function (a, b) { return intVal(a) + intVal(b); } ) :0;
                                $( api.column( 4 ).footer() ).html(debe.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") );
                            data = api.column( 5 ).data(); debe = data.length ? data.reduce( function (a, b) { return intVal(a) + intVal(b); } ) :0;
                                $( api.column( 5 ).footer() ).html(debe.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") );
                            data = api.column( 6 ).data(); debe = data.length ? data.reduce( function (a, b) { return intVal(a) + intVal(b); } ) :0;
                                $( api.column( 6 ).footer() ).html(debe.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") );
                            data = api.column( 7 ).data(); debe = data.length ? data.reduce( function (a, b) { return intVal(a) + intVal(b); } ) :0;
                                $( api.column( 7 ).footer() ).html(debe.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") );
                            data = api.column( 8 ).data(); debe = data.length ? data.reduce( function (a, b) { return intVal(a) + intVal(b); } ) :0;
                                $( api.column( 8 ).footer() ).html(debe.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") );
                            data = api.column( 9 ).data(); debe = data.length ? data.reduce( function (a, b) { return intVal(a) + intVal(b); } ) :0;
                                $( api.column( 9 ).footer() ).html(debe.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,") );                            

                        }
                    } 
                  );
               });
//////////////////////////////////////////////////////////////// END DATATABLE ////////////////////////////////////////////////////////////////
</script>      


 
<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>

<script type="text/javascript">
  /* API method to get paging information */
  $.fn.dataTableExt.oApi.fnPagingInfo = function ( oSettings )
  {
      return {
          "iStart":         oSettings._iDisplayStart,
          "iEnd":           oSettings.fnDisplayEnd(),
          "iLength":        oSettings._iDisplayLength,
          "iTotal":         oSettings.fnRecordsTotal(),
          "iFilteredTotal": oSettings.fnRecordsDisplay(),
          "iPage":          oSettings._iDisplayLength === -1 ?
              0 : Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength ),
          "iTotalPages":    oSettings._iDisplayLength === -1 ?
              0 : Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength )
      };
  }

  /* Bootstrap style pagination control */
  $.extend( $.fn.dataTableExt.oPagination, {
      "bootstrap": {
          "fnInit": function( oSettings, nPaging, fnDraw ) {
              var oLang = oSettings.oLanguage.oPaginate;
              var fnClickHandler = function ( e ) {
                  e.preventDefault();
                  if ( oSettings.oApi._fnPageChange(oSettings, e.data.action) ) {
                      fnDraw( oSettings );
                  }
              };

              $(nPaging).addClass('pagination').append(
                  '<ul>'+
                      '<li class="prev disabled"><a href="#">&larr; '+oLang.sPrevious+'</a></li>'+
                      '<li class="next disabled"><a href="#">'+oLang.sNext+' &rarr; </a></li>'+
                  '</ul>'
              );
              var els = $('a', nPaging);
              $(els[0]).bind( 'click.DT', { action: "previous" }, fnClickHandler );
              $(els[1]).bind( 'click.DT', { action: "next" }, fnClickHandler );
          },

          "fnUpdate": function ( oSettings, fnDraw ) {
              var iListLength = 5;
              var oPaging = oSettings.oInstance.fnPagingInfo();
              var an = oSettings.aanFeatures.p;
              var i, j, sClass, iStart, iEnd, iHalf=Math.floor(iListLength/2);

              if ( oPaging.iTotalPages < iListLength) {
                  iStart = 1;
                  iEnd = oPaging.iTotalPages;
              }
              else if ( oPaging.iPage <= iHalf ) {
                  iStart = 1;
                  iEnd = iListLength;
              } else if ( oPaging.iPage >= (oPaging.iTotalPages-iHalf) ) {
                  iStart = oPaging.iTotalPages - iListLength + 1;
                  iEnd = oPaging.iTotalPages;
              } else {
                  iStart = oPaging.iPage - iHalf + 1;
                  iEnd = iStart + iListLength - 1;
              }

              for ( i=0, iLen=an.length ; i<iLen ; i++ ) {
                  // Remove the middle elements
                  $('li:gt(0)', an[i]).filter(':not(:last)').remove();

                  // Add the new list items and their event handlers
                  for ( j=iStart ; j<=iEnd ; j++ ) {
                      sClass = (j==oPaging.iPage+1) ? 'class="active"' : '';
                      $('<li '+sClass+'><a href="#">'+j+'</a></li>')
                          .insertBefore( $('li:last', an[i])[0] )
                          .bind('click', function (e) {
                              e.preventDefault();
                              oSettings._iDisplayStart = (parseInt($('a', this).text(),10)-1) * oPaging.iLength;
                              fnDraw( oSettings );
                          } );
                  }

                  // Add / remove disabled classes from the static elements
                  if ( oPaging.iPage === 0 ) {
                      $('li:first', an[i]).addClass('disabled');
                  } else {
                      $('li:first', an[i]).removeClass('disabled');
                  }

                  if ( oPaging.iPage === oPaging.iTotalPages-1 || oPaging.iTotalPages === 0 ) {
                      $('li:last', an[i]).addClass('disabled');
                  } else {
                      $('li:last', an[i]).removeClass('disabled');
                  }
              }
          }
      }
  } );

  var oTable = $('.data-table').dataTable({
    "iDisplayStart": 10,
    "aLengthMenu": [[10, 50, 100, -1], [10, 50, 100, 'All']],
    "sPaginationType": "bootstrap"
  });
</script>






<script type="text/javascript">
$(function(){
    $('.source-code').each(function(index){
        var $section = $(this);
        var code = $(this).html().replace('<!--', '').replace('-->', '');
        
        // Code preview
        var $codePreview = $('<pre class="prettyprint lang-javascript"></pre>');
        $codePreview.text(code);
        $section.html($codePreview);
        
        // Run code
        if($section.hasClass('runnable')){
            var $button = $('<button class="btn btn-primary">Run the code</button>');
            $button.on('click', {code: code}, function(event){
                eval(event.data.code);
            });
            $button.insertAfter($section);
            $('<div class="clearfix" style="margin-bottom: 10px;"></div>').insertAfter($button);
        }
    });
});
</script>
