   <form id="RespuestaRegistroLlamada">
      <block>
       <assign name="CODIGO_RESULTADO" expr='"<?php echo @$response?>"'/>
       <assign name="DESC_RESULTADO" expr='"<?php echo @$description?>"'/>
      </block>
      <block>
         <assign name="INTV_RETURN_LEG" expr='""' />
         <clear namelist="INTV_RETURN_VALUE" />
         <return namelist="CODIGO_RESULTADO" />
         <return namelist="DESC_RESULTADO" />         
      </block>
   </form>
   <script><![CDATA[
   var CODIGO_RESULTADO;
   var DESC_RESULTADO;   
   var INTV_DOC_NAME='RespuestaRegistroLlamada'; 
   var INTV_ERROR_COUNT=0;
   var INTV_NOINPUT_COUNT=0;
   var INTV_NOMATCH_COUNT=0;
   var INTV_CONFIRM_COUNT=0; 
   var INTV_RETURN_VALUE;
   var INTV_RETURN_LEG;
   var INTV_NULL;  
   ]]></script>