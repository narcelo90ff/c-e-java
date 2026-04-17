using System;
using System.Collections.Generic;
using System.Linq;

public class Curso
{
    public int Id { get; set; }
    public string Nome { get; set; }
    public int CargaHoraria { get; set; }
}

public class CursoService
{
    private List<Curso> _cursos = new List<Curso>();

    public void Adicionar(Curso curso) => _cursos.Add(curso);

    public List<Curso> FiltrarPorCargaHoraria(int minima)
    {
        return _cursos.Where(c => c.CargaHoraria >= minima).ToList();
    }

    public List<Curso> ListarOrdenadoPorNome()
    {
        return _cursos.OrderBy(c => c.Nome).ToList();
    }

    public List<Curso> ListarTodos() => _cursos;
}

class Program
{
    static void Main()
    {
        var service = new CursoService();

        service.Adicionar(new Curso { Id = 1, Nome = "Desenvolvimento C#", CargaHoraria = 80 });
        service.Adicionar(new Curso { Id = 2, Nome = "Banco de Dados SQL", CargaHoraria = 40 });
        service.Adicionar(new Curso { Id = 3, Nome = "Lógica de Programação", CargaHoraria = 20 });
        service.Adicionar(new Curso { Id = 4, Nome = "Arquitetura de Sistemas", CargaHoraria = 60 });
        service.Adicionar(new Curso { Id = 5, Nome = "UI/UX Design", CargaHoraria = 30 });

        Console.WriteLine("--- Todos os Cursos (Ordenados por Nome) ---");
        var ordenados = service.ListarOrdenadoPorNome();
        foreach (var c in ordenados)
        {
            Console.WriteLine($"ID: {c.Id} | Nome: {c.Nome} | Carga: {c.CargaHoraria}h");
        }

        Console.WriteLine("\n--- Cursos com Carga Horária >= 40h ---");
        var filtrados = service.FiltrarPorCargaHoraria(40);
        foreach (var c in filtrados)
        {
            Console.WriteLine($"- {c.Nome} ({c.CargaHoraria}h)");
        }
    }
}
