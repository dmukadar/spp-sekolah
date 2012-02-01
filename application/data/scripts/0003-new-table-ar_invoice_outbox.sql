
CREATE TABLE IF NOT EXISTS `ar_invoice_outbox` (
  `invoice_id` bigint(20) NOT NULL,
  `sent_date` datetime NOT NULL,
  PRIMARY KEY (`invoice_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
