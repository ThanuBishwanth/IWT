public class student 
{
	String name;
	int age;
	public student(String name, int age)
	{
		this.name = name;
		this.age = age;
	}
	public void display() 
	{
		System.out.println("Name: " + name);
		System.out.println("Age: " + age);
	}
	public static void main(String[] args)
	{
	student student = new student("john",22);
	student.display();
    }
}
