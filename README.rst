========
iCompare
========

-------------------------------------------------------------------------------------
jQuery comparsion plugin.
-------------------------------------------------------------------------------------

Abstract
========

Convert simple html table into a powerfull comparsion tool.

Items must be enumerated in columns and its propertys in rows (one row per item).

The first row must consist in an empty data cell (<td>) followed by many heading (<th>) cells containing the names of the items to be compared.

Following rows must start with heading (<th>) containing the property name and many data cells (<td>) with the property value for each item.

Usage
=====

  $("table#MyTable").iCompare(); 


Dependencys
===========

  * jQuery: http://jquery.com/


Example
=======

::
  <script type="text/javascript" charset="utf-8">
    $(function(){
      $(".compare").iCompare();
    });
  </script>
  <table class="compare">
    <tr>
      <td></td>
      <th>Mod-3630QM</th>
      <th>Mod-330QMM</th>
      <th>Mod-2430M</th>
      <th>Mod-560UM</th>
      <th>Mod-2450M</th>
    </tr>
    <tr>
      <th>Processor</th>
      <td>2.4GHz</td>
      <td>2.4GHz</td>
      <td>2.4GHz</td>
      <td>1.7GHz</td>
      <td>2.5GHz</td>
    </tr>
    <tr>
      <th>Video Card</th>
      <td>GeForce GT 650M</td>
      <td>AMD Radeon HD 6770M</td>
      <td>NVIDIA GeForce GT 525M</td>
      <td>Intel HD Graphics 4000</td>
      <td>NVIDIA GeForce GT 640M LE</td>
    </tr>
    <tr>
      <th>Audio</th>
      <td>Beats Audio</td>
      <td>Integrated</td>
      <td>Beats Audio</td>
      <td>Integrated</td>
      <td>Integrated</td>
    </tr>
    <tr>
    <th>Memory</th>
      <td>8GB</td>
      <td>4GB</td>
      <td>6GB</td>
      <td>4GB</td>
      <td>6GB</td>
      tr>
    <tr>
      <th>Hard Disk</th>
      <td>750GB</td>
      <td>750GB</td>
      <td>500GB</td>
      <td>1TB</td>
      <td>1TB</td>
    </tr>
    <tr>
      <th>Battery Life</th>
      <td>7</td>
      <td>7</td>
      <td>5</td>
      <td>5</td>
      <td>6</td>
    </tr>
    <tr>
      <th>Screen Resolution</th>
      <td>1280 x 720</td>
      <td>1366 x 768</td>
      <td>1600 x 900</td>
      <td>1920 x 1080</td>
      <td>1600 x 900</td>
    </tr>
    <tr>
      <th>Number of USB Ports </th>
      <td>4</td>
      <td>3</td>
      <td>3</td>
      <td>2</td>
      <td>3</td>
    </tr>
  </table>
