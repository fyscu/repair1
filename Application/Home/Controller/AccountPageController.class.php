<?php
	namespace Home\Controller;
	use Think\Controller;

	class AccountPageController extends Controller{

		public function logout(){
			session(null);
			$this->success('退出成功！',C('UC_LOGIN_URL'));
		}

		public function ucLogin(){

			if(!$_GET['access_token']){
				$this->error('没有token,请重新登录',C('UC_LOGIN_URL'));
				exit;
			}
			$userinfo= json_decode(curl(C('UC_API').'/getuserinfo?appid=1009&appkey=533e55482f4d07df&token='.$_GET['access_token']),1);

			//dump($userinfo);exit;
			//以下是测试服务器上务必注释掉
			// $userinfo=array(
			// 	code=>0,
			// 	data=>array(
			// 		array(
			// 			"uid"=>1126,
			// 			"token"=>'debug',
			// 			'tel'=>'18613227075'
			// 		)
			// 	)
			// );

			// dump($userinfo);exit;

			if($userinfo['code']!=0){
				$this->error('获取资料失败,请重新登录'.$userinfo['msg'],C('UC_LOGIN_URL'));
				exit;
			}

			session('ucid',$userinfo['data'][0]['uid']);
			session('access_token',$_GET['access_token']);
			$a=is_user($userinfo['data'][0]['uid'],'ucid');
			$telUser=is_userExtend($userinfo['data'][0]['tel']);
			if($a){
				// dump($a);exit;


				$user_id=$a['user_id'];
				$type=$a['type'];
				session('user_id',$user_id);
				session('type',$type);
				if($_SESSION['type']==3){
					$b=M('admin');
					$admin_map['user_id']=$user_id;
					$c=$b->where($admin_map)->find();
					session('admin_id',$c['admin_id']);
					redirect('/Home/AdminPage/index?access_token='.$_GET['access_token']);
				}elseif($_SESSION['type']==2){
					$b=M('staff');
					$staff_map['user_id']=$user_id;
					$c=$b->where($staff_map)->find();
					//dump($c);exit;
					session('staff_id',$c['staff_id']);
					redirect('/Home/StaffPage/not?access_token='.$_GET['access_token']);

				}else{
					redirect('/Home/Index/index?access_token='.$_GET['access_token']);
				}
			}else if($telUser){
				$user=M('user');
				$usermap['user_id']=$telUser['user_id'];
				$data['ucid']=$userinfo['data'][0]['uid'];
				$user->where($usermap)->save($data);
				$user_id=$telUser['user_id'];
				$type=$user->where($usermap)->getField('type');


				session('user_id',$user_id);
				session('type',$type);
				if($_SESSION['type']==3){
					$b=M('admin');
					$admin_map['user_id']=$user_id;
					$c=$b->where($admin_map)->find();
					session('admin_id',$c['admin_id']);
					redirect('/Home/AdminPage/index?access_token='.$_GET['access_token']);
				}elseif($_SESSION['type']==2){
					//echo '2';exit;
					$b=M('staff');
					$staff_map['user_id']=$user_id;
					$c=$b->where($staff_map)->find();
					//dump($c);exit;
					session('staff_id',$c['staff_id']);
					redirect('/Home/StaffPage/not?access_token='.$_GET['access_token']);

				}else{
					//dump($_SESSION);exit;
					redirect('/Home/Index/index?access_token='.$_GET['access_token']);
				}
			}else{

				session('tel',$userinfo['data'][0]['tel']);
				redirect('/Home/AccountPage/register?access_token='.$_GET['access_token']);
			}

		}
		public function register(){


			if (C('STOP_REPAIR')) {
				$this->error('您好,飞扬报修系统由于一些原因暂时关闭系统。系统重新开放后，我们将会在四川大学飞扬俱乐部官方微信/微博进行通知，尽请留意！', '', 8);
				exit;
			}

			if($_GET['access_token']){
				$uid=is_tokenLogin($_GET['access_token']);
				if(!$uid){
					$this->error('登录超时,请重新登录',C('UC_LOGIN_URL'));
				}else{

					if(is_userExtend($_SESSION['tel'])){
						$this->error('您已经注册过飞扬报修系统了,将跳转至首页','/Home/Index/index?access_token='.$_GET['access_token']);
						exit;
					}else{
						$this->display();
					}
				}
			}else if($_SESSION['access_token']){
					redirect(__SELF__.'?access_token='.$_SESSION['access_token']);
			} else {
				not_login();
			}



		}


	}
?>
