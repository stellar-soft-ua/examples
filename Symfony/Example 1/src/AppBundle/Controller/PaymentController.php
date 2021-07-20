<?php

namespace AppBundle\Controller;

use AppBundle\Entity\FinanceTransaction;
use AppBundle\Entity\Notification;
use DateTime;
use Exception;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use WayForPay\SDK\Domain\Transaction;

class PaymentController extends Controller
{

    /**
     * @Rest\Post("/payment/setStatus")
     */
    public function setStatus(Request $request)
    {

        $json = file_get_contents('php://input');
        $obj = json_decode($json, TRUE);

        $this->get('logger')->notice('WAYFORPAY: ' . json_encode($obj));


        $transactionStatus = $obj['transactionStatus'];
        $orderReference = $obj['orderReference'];
        $merchantSignature = $obj['merchantSignature'];
        $reasonCode = $obj['reasonCode'];
        $currency = $obj['currency'];
        $authCode = $obj['authCode'];
        $cardPan = $obj['cardPan'];
        $amount = $obj['amount'];

        $baseAmount = $obj['baseAmount'];
        $baseCurrency = $obj['baseCurrency'];

        $em = $this->getDoctrine()->getManager();

        $order = $this->getDoctrine()->getRepository('AppBundle:PaymentOrder')->find($orderReference);

        if ($order === null) {
            $this->get('logger')->error('Order is not found');
            return null;
        }

        $merchantKey = $this->container->getParameter('merchants')[$order->getMerchant()->getTitle()];


        if ($merchantSignature !== hash_hmac('md5', implode(';', [
                'merchantAccount' => $order->getMerchant()->getTitle(),
                'orderReference' => $order->getId(),
                'amount' => $amount,
                'currency' => $currency,
                'authCode' => $authCode,
                'cardPan' => $cardPan,
                'transactionStatus' => $transactionStatus,
                'reasonCode' => $reasonCode
            ]), $merchantKey)) {
            $this->get('logger')->error('WAYFORPAY: ERROR - order ' . $orderReference . " - WRONG Signature - " . var_export($obj, true));
            return false;
        }

        try {

            if ($transactionStatus === 'Approved' && $order->getStatus() !== 'Approved') {

                $financeAccount = $order->getMerchant()->getFinanceAccount();

                foreach ($order->getPaymentOrderBills() as $paymentOrderBill) {
                    $bonusesSum = $paymentOrderBill->getBonusesSum();
                    $moneySum = $paymentOrderBill->getSum();
                    $bill = $paymentOrderBill->getBill();

                    $this->get('app.purchase_manager')->payBill($bill, $moneySum, $bonusesSum, $financeAccount, $order->getRegionSum());

                }


                if ($order->getRegionSum() && $order->getRegionSum() !== $order->getSum()) {

                    if(!$baseAmount){
                        throw new Exception("no baseAmount");
                    }

                    $financeTransaction = new FinanceTransaction();
                    $financeTransaction
                        ->setTime(time())
                        ->setFinanceAccount($financeAccount)
                        ->setOffice($bill->getOffice())
                        ->setCurrencyCode('UAH')
                        ->setOriginalCurrencySum('UAH');

                    $delta = $order->getSum() - $baseAmount;

                    if ($delta > 0) {
                        $financeTransaction
                            ->setSum($delta)
                            ->setFinanceItem($this->getDoctrine()->getRepository("AppBundle:FinanceItem")->find(529))
                            ->setDescription("Расход по курсовой разнице");
                    } else {
                        $financeTransaction
                            ->setSum(abs($delta))
                            ->setFinanceItem($this->getDoctrine()->getRepository("AppBundle:FinanceItem")->find(530))
                            ->setDescription("Доход по курсовой разнице");
                    }

                    $em->persist($financeTransaction);

                }


                $notification = new Notification();
                $notification
                    ->setClient($order->getClient())
                    ->setType('message')
                    ->setTime(new DateTime())
                    ->setText("Оплата успешно проведена");

                $em->persist($notification);


            }


        } catch (Exception $e) {

            $this->get('logger')->error('WAYFORPAY: ERROR - order ' . $orderReference . " - " . $e->getMessage());
            return false;
        }


        $order->setStatus($transactionStatus);

        $em->persist($order);
        $em->flush();

        $data = [
            'orderReference' => $orderReference,
            'status' => 'accept',
            'time' => time()
        ];

        $data['signature'] = hash_hmac('md5', implode(';', $data), $merchantKey);

        $this->get('logger')->notice('WAYFORPAY: Response - ' . json_encode($data));
        return $data;

    }
}
