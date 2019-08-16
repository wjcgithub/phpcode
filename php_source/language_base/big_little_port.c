#include<stdio.h>

void func1()
{
    int i = 0x12345678;
    printf("%x", *((char*)(&i)));
    if( *((char*)(&i)) == 0x12 )  {
        printf("func1 says Big endian!\n");
    } else {
        printf("func1 says Little endian!\n");
    }
}

void func2() {
    union _u{
        int i;
        char c;
    }u;

    u.i = 1;
    if(u.c == 1) {
        printf("func2 says Little endian!\n");
    } else {
        printf("func2 says Big endian!\n");
    }
}

int main(){
    func1();
    func2();
    return 1;
}