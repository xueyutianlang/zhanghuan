<?php
/**
 * @description: parent 关键字
 *
 * @author: snow wolf
 * @date  : 2016-08-08
 **/

//定义员工类
class employee
{
    protected $salary = 2000;// 员工的基本工资
    
    /* 全体员工进行调薪工作 */
    //private function salaryIncrease()//Call to private method employee::salaryIncrease() from context 'Manager' 
    protected function salaryIncrease() 
    {
        $this->salary += 1500;
        return $this->salary;
    }
}

class Manager extends employee
{
    protected $salary = 5000;// 覆盖员工类基本工资

    /*
     * 经理调薪 
     * 覆盖 员工调薪方法
     */
    public function salaryIncrease()
    {
       parent::salaryIncrease();
       return $this->salary;
    }

    /*
     * 自定义经理调薪方法 
     * @notice : 为了更清楚理解覆盖的含义,此处动作并没有覆盖员工类的调薪方法，而是新定义了一个方法
     */
    public function getNum()
    {
        parent::salaryIncrease();
        return $this->salary;
    }
}

$a = new Manager;
echo $a->salaryIncrease();
echo $a->getNum();

