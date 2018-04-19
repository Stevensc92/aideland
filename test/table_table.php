<table border="border">
<?php
// 1ère ligne
echo "<tr><td></td>";
for ($c=0;$c<14;$c++)
{
    echo "<th>$c</th>";
}
echo "</tr>\n";
// toutes les lignes
for ($l=0;$l<14;$l++)
{
    // 1 ligne
    echo "<tr><th>$l</th>";
    for ($c=0;$c<14;$c++)
    {
        $r=$c*$l;
        echo "<td align=\"right\">$r</td>";
    }
    echo "</tr>\n";
}
?>
</table>