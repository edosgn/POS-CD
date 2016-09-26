<?php
namespace AppBundle\Twig;

class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('sum', 'array_sum'),
        );
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('get-ramdon-string', array($this, 'randomString'))
        );
    }

    public function randomString($length=8,$uc=TRUE,$n=TRUE,$sc=FALSE) {
        $source = 'abcdefghijklmnopqrstuvwxyz';
        if($uc==1) $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        if($n==1) $source .= '1234567890';
        if($sc==1) $source .= '|@#~$%()=^*+[]{}-_';
        if($length>0){
            $rstr = "";
            $source = str_split($source,1);
            for($i=1; $i<=$length; $i++){
                mt_srand((double)microtime() * 1000000);
                $num = mt_rand(1,count($source));
                $rstr .= $source[$num-1];
            }
     
        }
        return $rstr;
    }
    
    public function getName()
    {
        return 'app_extension';
    }
}