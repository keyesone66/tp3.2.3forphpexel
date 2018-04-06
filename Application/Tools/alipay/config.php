<?php
$config = array (
		//应用ID,您的APPID。
		'app_id' => "2016082700322878",

		//商户私钥
		'merchant_private_key' => "MIIEpAIBAAKCAQEAtes9IFdKt6t6Bi2DsIAPtt3H64c+WyMjSyojgA/3zKyLIWYA9JtNOC/PqLFfTWYeWK5M1iBtQafvXqsEO6ewPGSNsOlgiWugVTOM9zOiXrzddHCMd9v89SzQM77lH1PA/7RYHobbnsniW+3iltsxGmXj0hzeMRXBNutztSEL19Y/BrtWsjWqKYJT/1eVfy+2IzK3aW6UCFDKXBJ8sAFRQNvoXSEPVSvWUYcOwydLxa0ANlnzO4UcxEgux/H5yevWpXQsTHybP6wvxNRsqppHyTEdKU7jbhTxxwyVtB0qTa1hGA/ZSeOBIQUPG9aMNqEQ516ACZYN7zJZDhub+v+P9wIDAQABAoIBACsVYC+lnMNs8ARAiTymx5H2al+EcycgZj5p52hv367wei7ZuoYztZEF+bco8rog4jT8aqQXn+h5vj38YI9EQn+7DLeGPd+txpYHFG6DIwQu1H+8G/hS+FCUYWav4hGOQ1oLuwbXx3GOvHYrG4vAs5td4BulzJVxYoYAMzIFdomSBLajPrKoxCyjobDZ8A1weJdn7uw1zEE2oe9zBJX20QNK7Sx/hBFIMpHh8VSxDaBMfUujy+nRSgm+uKYKEjmUMTsGS9sGDT8FUIDEu00orIVUnLIjqsbNfHV+E13jrYmVLBRq2jvAOiCFwEYXjwcXY9xmxpPU/YZgCfkv2SrGpNECgYEA2uk7LWdNp7zzRYEOVGVBWstQ0FqsB4DcBxPiz+ADu2Qzn3XLe+d+KZ0ENR2BB0iZ8GlN6ml/ShD23FamEMk0/x/J9rUQ8EATpIJdU5X+BHyw9jyIIFzB/BUTOYPzSE3g9UF3h64pgWE6N2Fp58n97oGKLGu/wSHbmz0zblf3ulkCgYEA1L2OlnunfRCs1sTznsNlZFWdN4+6vV31qMZuL5eKzjgqdmcqjP/K3v5Lva39Lz0gS+K8HOqLsGBXZtltKEMgt/dIJ+E/jyOkXIPPSgC8XXU4t5Af9jUHXUsC1HHj/dpYjthHSmP8iXW8vm3pmOJtz42Na5JuN+YBFWC4HAtOss8CgYEAif8Wl+OUF1ZMQJc/UkJWNYcPVZii80Pu7+NASmxbzeg3hqD5+gyPAmqBuX301YOVzvCC9m80l5skEvfoTZKY/u6qIQQ5PkoWV9D6RfO6old8Mm0sHsJ6Yo9ihBJC7WRymAiB8hz++xkwWrLk0QILOiucz63IvlW6mxy0bC2181kCgYEAj1GwmLJvUHMGbZ27ni52xRRkWQUMQfzlvbEIlClcircN7DxuTxUYIAhjEEMBuWxNsLHsFvLv7n/JAfHiduhaR3Vg9/Toc88IMIdgA7PhMnkBH7EJxz1MW85n9qVPejo5xOnxhS08+YIHCKdVYvjQD66GIn1AoYnjGvrQrZv0hcMCgYBEVBHV3pBsWN8sqoSHY8/DwBhqfI1dE7J/3VVqCKN86dgZDG0/6bcwl4pHZfqvb2Sa5BFjUMXa9y7VkzPEdHdsMEkQKP9PdPRdeCfTwr2s9UoHsthWZVSQJGOPEqMArcoOPT+yOwP2DqkrAyVA1O4OD/2SjZU7P8iP7RTrGLR/ug==",

		//异步通知地址 无论用户是否关闭浏览器页面 都从支付宝平台发起一个post请求 发送到指定页面
		'notify_url' => "http://www.eshop.com/home/order/check",

		//同步跳转 支付成功后 返回商家
		'return_url' => "http://www.eshop.com/home/cart/flow3",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		//正式签约 商用网关
		// 'gatewayUrl' => "https://openapi.alipay.com/gateway.do",

		//沙箱测试网关
		'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",


		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAmwRTO8Oww+C6K2REhdUm2AgPclF3X/3aB1BiEB+bJ6bEMwDBYmm7O7mq+6Ma7tnqJThYvbMF4eI61WxgFh+rvbgAHdA1zYV9uZZs8t3smwljvYWsMCHM7aLkO1cv74ZtZcdgancg0EZA/UP6kdpTDZgnVuKdasgrm7mJXj7JM8ZJNGFKAI0KaKjl0YtMW9ttyrJroX6z810sSyczOeJbzqteykyLgyLQXiNchis2m9vd3/J9MY020GNnaCM9MkA1K4A/7IRc6Bqgh+dhmAgS4VOMcXMkRSinynRv+1y7xOH8MQBczcBV98zUVDtGLjaqK40RJT0+DlzPe6fnZFggPQIDAQAB",
);
