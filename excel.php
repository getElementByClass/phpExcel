<?php
/**
 * 导入导出控制器
 * @authors Your Name (you@example.org)
 * @date    2017-12-17 20:04:29
 * @version $Id$
 */
 
    header("Content-type: text/html; charset=utf-8");  
    require_once("class.Request.php");
    require_once("PHPExcel/PHPExcel.php");
    require_once("PHPExcel/phpexcel/Shared/Date.php");

    $response = new Request();

    //获取导出数据
    $res = $response->sendParameter($_POST['url'],$_POST);
    
    // var_dump($_POST['url'] == "/api/rpt/listReportRevenue");
    // exit;
    
    function delFileUnderDir( $dirName="temp" ){
        if ( $handle = opendir( "$dirName" ) ) {
            while ( false !== ( $item = readdir( $handle ) ) ) {
                if ( $item != "." && $item != ".." ) {
                    if ( is_dir( "$dirName/$item" ) ) {
                            delFileUnderDir( "$dirName/$item" );
                    } else {
                        if( unlink( "$dirName/$item" ) ){}
                            // echo "成功删除文件： $dirName/$item<br />n";
                    }
                }
            }
            closedir( $handle );
        }
    }
    delFileUnderDir();
    //unlink('./temp/'.$_POST['fileName'].'.xlsx');
    //创建一个excel
    
    $objPHPExcel = new PHPExcel();

    //border样式
    $styleThinBlackBorderOutline = array(
        'borders' => array (
            'outline' => array (
                  'style' => PHPExcel_Style_Border::BORDER_THIN,   //设置border样式
                  'color' => array ('argb' => 'FF000000'),          //设置border颜色
           ),
        ),
    );
    //设置当前的sheet
    $objPHPExcel->setActiveSheetIndex(0);
    //设置单元格的值
    $titles=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
    //设置表头  
    $key1 = 2;  
    switch ($_POST['url']) {
        case "/api/rpt/listReportRevenue":
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$key1, '日期')  
            ->setCellValue('A'.($key1+1), '日期')  
            ->setCellValue('B'.$key1, '收入项目')  
            ->setCellValue('B'.($key1+1), '临停')  
            ->setCellValue('C'.$key1, '收入项目')  
            ->setCellValue('C'.($key1+1), '包月')  
            ->setCellValue('D'.$key1, '收入项目')  
            ->setCellValue('D'.($key1+1), '商户充值')  
            ->setCellValue('E'.$key1, '收款通道')  
            ->setCellValue('E'.($key1+1), '现金')  
            ->setCellValue('F'.$key1, '收款通道')  
            ->setCellValue('F'.($key1+1), '招行')  
            ->setCellValue('G'.$key1, '合计')  
            ->setCellValue('G'.($key1+1), '合计');  
            $tempArr = array('reportdate','parkingAmount','monthlyAmount','merchantsAmount',"cashAmount","cmbAmount","amountCount");
            break;
        case "/api/pklot/listExportParkIncomeDetail":
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$key1, '时间')  
            ->setCellValue('B'.$key1, '房号')  
            ->setCellValue('C'.$key1, '车主')  
            ->setCellValue('D'.$key1, '包月起始')  
            ->setCellValue('E'.$key1, '包月结束')  
            ->setCellValue('F'.$key1, '应付')
            ->setCellValue('G'.$key1, '实付')
            ->setCellValue('H'.$key1, '付款方式')
            ->setCellValue('I'.$key1, '备注');
            $tempArr = array('paymenTime','roomNumber','ownerName','expdatStart',"expdateEnd","amountReceivable","actPay","paymentType","remarks");
            break;
        case "/api/fce/listExportTemporaryParkingDetail":
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$key1, '付款时间')  
            ->setCellValue('B'.$key1, '车牌号')  
            ->setCellValue('C'.$key1, '消费金额')  
            ->setCellValue('D'.$key1, '抵扣金额')  
            ->setCellValue('E'.$key1, '应付')  
            ->setCellValue('F'.$key1, '实付')
            ->setCellValue('G'.$key1, '付款类别')
            ->setCellValue('H'.$key1, '付款通道')
            ->setCellValue('I'.$key1, '备注');
            $tempArr = array('incomeTime','incomeName','amountTotal','amountDiscount',"amountReceivable","amountPayed","payType","payTypeCode","remarks");
            break;
        default:
            
            break;
    };
    $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial');
    $objPHPExcel->getDefaultStyle()->getFont()->setSize(12);
    $objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    //设置工作簿的名称  
    $objPHPExcel->getActiveSheet()->setTitle($_POST['fileName']);
    $objPHPExcel->getActiveSheet()->mergeCells('A1:'.$titles[count($res['data'][0])-1].'1');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $_POST['fileName']);
    $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(60); 
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

    if ($_POST['url'] == "/api/rpt/listReportRevenue") {
        
        $objPHPExcel->getActiveSheet()->mergeCells('A'.$key1.':A'.($key1+1));
        $objPHPExcel->getActiveSheet()->mergeCells('B'.$key1.':D'.$key1);
        $objPHPExcel->getActiveSheet()->mergeCells('E'.$key1.':F'.$key1);
        $objPHPExcel->getActiveSheet()->mergeCells('G'.$key1.':G'.($key1+1));
        $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

    }

    foreach($res['data'] as $key =>$value){ 
        if ($_POST['url'] == "/api/rpt/listReportRevenue") {
            $key1=$key+4;
        } else{
            $key1=$key+3;  
        }
        for ($i=0; $i < count($value) ; $i++) { 
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($titles[$i].$key1, $value[$tempArr[$i]]);//设置excel每一行内容

            $objPHPExcel->getActiveSheet()->getColumnDimension($titles[$i])->setWidth(18); //设置宽度
            if ($_POST['url'] == "/api/rpt/listReportRevenue") {
                $objPHPExcel->getActiveSheet()->getStyle($titles[$i].'2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//设置表头背景色
                $objPHPExcel->getActiveSheet()->getStyle($titles[$i].'2')->getFill()->getStartColor()->setARGB('c5ede7');
                $objPHPExcel->getActiveSheet()->getStyle($titles[$i].'3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//设置表头背景色
                $objPHPExcel->getActiveSheet()->getStyle($titles[$i].'3')->getFill()->getStartColor()->setARGB('c5ede7');
            } else{
                $objPHPExcel->getActiveSheet()->getStyle($titles[$i].'2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);//设置表头背景色
                $objPHPExcel->getActiveSheet()->getStyle($titles[$i].'2')->getFill()->getStartColor()->setARGB('c5ede7'); 
            }

            $objPHPExcel->getActiveSheet()->getStyle($titles[$i].$key)->applyFromArray($styleThinBlackBorderOutline);//设置内容border

            if(is_numeric($value[$tempArr[$i]])){
                $objPHPExcel->getActiveSheet()->getStyle($titles[$i].$key1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            };
        };
    };
    
    for ($j=0; $j < count($tempArr); $j++) { 
        $objPHPExcel->getActiveSheet()->getStyle($titles[$j].count($res['data']))->applyFromArray($styleThinBlackBorderOutline);//设置内容border
        $objPHPExcel->getActiveSheet()->getStyle($titles[$j].(count($res['data'])+1))->applyFromArray($styleThinBlackBorderOutline);//设置内容border
        $objPHPExcel->getActiveSheet()->getStyle($titles[$j].(count($res['data'])+2))->applyFromArray($styleThinBlackBorderOutline);//设置内容border
        if ($_POST['url'] == "/api/rpt/listReportRevenue") {
            $objPHPExcel->getActiveSheet()->getStyle($titles[$j].(count($res['data'])+3))->applyFromArray($styleThinBlackBorderOutline);//设置内容border
        }
    } 



    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    $objWriter->save("temp/".$_POST['fileName'].".xlsx");

    echo json_encode(array(
        'status'=>'200',
        'url'=>'php/temp/'.$_POST['fileName'].'.xlsx'
    ));
?> 