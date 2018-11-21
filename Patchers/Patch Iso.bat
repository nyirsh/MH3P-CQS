@echo off
del BINs.cnf
del *.BIN
Dialogs.exe
copy BINs.cnf real_BINs.cnf
del BINs.cnf
EncryptedBINsMaker.exe
del BINs.cnf
copy real_BINs.cnf BINs.cnf
del real_BINs.cnf
FileEmbedder.exe clean.iso BINs.cnf
del data
MPB.exe
del BINs.cnf
del *.BIN
Patcher.exe