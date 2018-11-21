@echo off
MPB.exe
MakePPF3.exe c original.iso clean.iso ita.ppf
UBPM.exe clean.iso original.iso data.ubp
del enc_data.ubp