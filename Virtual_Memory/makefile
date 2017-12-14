all: v

v: main.o memory.o pagetable.o pagetableentry.o processtable.o

	g++ main.o memory.o pagetable.o pagetableentry.o processtable.o -o v

main.o: main.cpp
	g++ -c main.cpp

memory.o: memory.cpp
	g++ -c memory.cpp

pagetable.o: pagetable.cpp
	g++ -c pagetable.cpp

pagetableentry.o: pagetableentry.cpp
	g++ -c pagetableentry.cpp

processtable.o: processtable.cpp
	g++ -c processtable.cpp

clean:
	rm -f *.o
