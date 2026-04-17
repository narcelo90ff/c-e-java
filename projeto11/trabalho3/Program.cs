using System;
using System.Collections.Generic;
using Projeto.Models;
using Projeto.Repositories;
namespace Projeto
{
public class Program
{
public static void Main(string[] args)
{
var repo = new EstudanteRepository();
Console.WriteLine("=== INSERINDO ESTUDANTE ===");
var novoEstudante = new Estudante
{
Nome = "João Silva",
Idade = 22
};
repo.Adicionar(novoEstudante);
Console.WriteLine("Estudante inserido com sucesso.\n");
Console.WriteLine("=== LISTANDO ESTUDANTES ===");
var lista = repo.Listar();
foreach (var e in lista)
{
Console.WriteLine($"{e.Id} - {e.Nome} - {e.Idade}");
}
Console.WriteLine();
Console.WriteLine("=== BUSCANDO ESTUDANTE POR ID ===");
var estudante = repo.BuscarPorId(1);
if (estudante != null)
{
Console.WriteLine($"Encontrado: {estudante.Nome} - {estudante.Idade}");
}
else
{
Console.WriteLine("Estudante não encontrado.");
}
Console.WriteLine();
Console.WriteLine("=== ATUALIZANDO ESTUDANTE ===");
var estudanteAtualizado = new Estudante
{
Id = 1,
Nome = "Maria Oliveira",
Idade = 25
};
repo.Atualizar(estudanteAtualizado);
Console.WriteLine("Estudante atualizado.\n");
Console.WriteLine("=== LISTANDO APÓS ATUALIZAÇÃO ===");
lista = repo.Listar();
foreach (var e in lista)
{
Console.WriteLine($"{e.Id} - {e.Nome} - {e.Idade}");
}
Console.WriteLine();
Console.WriteLine("=== REMOVENDO ESTUDANTE ===");
repo.Remover(1);
Console.WriteLine("Estudante removido.\n");
Console.WriteLine("=== LISTA FINAL ===");
lista = repo.Listar();
foreach (var e in lista)
{
Console.WriteLine($"{e.Id} - {e.Nome} - {e.Idade}");
}
Console.WriteLine("\n=== FIM DA EXECUÇÃO ===");
}
}
}
var repo = new EstudanteRepository();
repo.Adicionar(new Estudante { Nome = "João", Idade = 20 });
var lista = repo.Listar();
foreach (var e in lista)
{
Console.WriteLine($"{e.Id} - {e.Nome} - {e.Idade}");
}
